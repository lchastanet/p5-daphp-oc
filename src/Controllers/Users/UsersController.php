<?php

namespace App\Controllers\Users;

use App\lib\Authenticator;
use App\lib\Controller;
use App\lib\Flash;
use App\lib\Validators\PostedValuesValidator;
use App\lib\Mailer;
use App\lib\Renderer;
use App\lib\Validators\EmailValidator;
use App\Model\Users\User;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct('Users');
    }

    public function executeSignIn()
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->manager->getByEmail($email);

            if (null != $user) {
                if (true == $user->validated()) {
                    $authenticator = new Authenticator();
                    if ($authenticator->checkCredentials($user, $password)) {
                        if ($user->role() == 1) {
                            $this->redirect('/admin');
                        }
                        $this->redirect('/');
                    } else {
                        $flash = new Flash('danger', 'Identifiant ou mot de passe incorrecte');
                        $flash->setFlash();
                        $this->redirect('/signIn');
                    }
                } else {
                    $flash = new Flash('danger', 'Veuillez verifier votre adresse email pour vous connecter');
                    $flash->setFlash();
                    $this->redirect('/signIn');
                }
            } else {
                $flash = new Flash('danger', 'Veuillez vous enregistrer sur le site pour vous connecter');
                $flash->setFlash();
                $this->redirect('/signUp');
            }
        } else {
            $renderer = new Renderer(
                'front',
                'signIn.twig',
                '../src/Controllers/Users/Views',
                ['title' => 'Connexion']
            );
            $renderer->render();
        }
    }

    public function executeSignUp()
    {
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $validator = new PostedValuesValidator('Formulaire incomplet, veuillez recommencer');
            $postedValues = $validator->isValid(['login', 'email', 'password', 'passwordValidation']);

            if (null != $postedValues) {
                $login = $postedValues['login'];
                $email = $postedValues['email'];
                $password = $postedValues['password'];
                $passwordConfirmation = $postedValues['passwordValidation'];
            } else {
                $flash = new Flash('danger', $validator->errorMessage());
                $flash->setFlash();

                $this->redirect('/signUp');
            }

            $user = new User([
                'login' => $login,
                'validated' => 0,
                'role' => 2,
            ]);

            $validator = new EmailValidator('Email incorrecte');

            if ($validator->isValid($email)) {
                $user->setEmail($email);
            } else {
                $flash = new Flash('danger', $validator->errorMessage());
                $flash->setFlash();

                $this->redirect('/signUp');
            }

            if ($password === $passwordConfirmation) {
                $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            } else {
                $flash = new Flash('danger', $validator->errorMessage());
                $flash->setFlash();

                $this->redirect('/signUp');
            }

            $user->setValidationToken(bin2hex(random_bytes(32)));

            $this->manager->save($user);

            $mailer = new Mailer($user);
            if ($mailer->sendMail()) {
                $flash = new Flash('success', 'Veuillez vérifier vos mails et cliquer sur le lien afin de finaliser votre inscription');
                $flash->setFlash();
                $this->redirect('/signIn');
            } else {
                $flash = new Flash('danger', 'Une erreur est survenue, veuillez contacter le webmaster');
                $flash->setFlash();
                $this->executeError(500);
            }
        } else {
            $renderer = new Renderer(
                'front',
                'signUp.twig',
                '../src/Controllers/Users/Views',
                ['title' => 'Inscription']
            );
            $renderer->render();
        }
    }

    public function executeValidateAccount($email, $validationToken)
    {
        $validator = new EmailValidator('Email incorrecte');

        if ($validator->isValid($email)) {
            $user = $this->manager->getByEmail($email);

            if ($user != null) {
                if ($user->validationToken() == $validationToken) {
                    $this->manager->validateAccount($user->id());

                    $flash = new Flash('success', 'votre compte à été validé avec succès, vous pouvez vous connecter!');
                    $flash->setFlash();

                    $this->redirect('/signIn');
                } else {
                    $flash = new Flash('danger', 'le lien ne semble plus fonctionner, veuillez contactez l\'adminisatrateur du site');
                    $flash->setFlash();

                    $this->redirect('/signUp');
                }
            }
        } else {
            $flash = new Flash('danger', $validator->errorMessage());
            $flash->setFlash();

            $this->redirect('/signUp');
        }
    }
}
