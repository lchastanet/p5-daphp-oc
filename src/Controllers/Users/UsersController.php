<?php

namespace App\Controllers\Users;

use App\lib\Authenticator;
use App\lib\Controller;
use App\lib\Flash;
use App\lib\Validators\PostedValuesValidator;
use App\lib\Mailer;
use App\lib\Renderer;
use App\lib\Validators\EmailValidator;
use App\lib\Validators\TwinsValidator;
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
                        $this->redirect('/admin');
                    } else {
                        $flash = new Flash('error', 'Identifiant ou mot de passe incorrecte');
                        $flash->setFlash();
                        $this->redirect('/signIn');
                    }
                } else {
                    $flash = new Flash('error', 'Veuillez verifier votre adresse email pour vous connecter');
                    $flash->setFlash();
                    $this->redirect('/signIn');
                }
            } else {
                $flash = new Flash('error', 'Veuillez vous enregistrer sur le site pour vous connecter');
                $flash->setFlash();
                $this->redirect('/signUp');
            }
        } else {
            $renderer = new Renderer(
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
                $passwordConfirmation = $postedValues['passwordConfirmation'];
            } else {
                $flash = new Flash('error', $validator->errorMessage());
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
                $flash = new Flash('error', $validator->errorMessage());
                $flash->setFlash();

                $this->redirect('/signUp');
            }

            $validator = new TwinsValidator('Les deux Emails ne correspondent pas');

            if ($validator->isValid($password, $passwordConfirmation)) {
                $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            } else {
                $flash = new Flash('error', $validator->errorMessage());
                $flash->setFlash();

                $this->redirect('/signUp');
            }

            $user->setValidationToken(bin2hex(random_bytes(32)));

            $this->manager->save($user);

            $mailer = new Mailer($user);
            if ($mailer->sendMail()) {
                $flash = new Flash('success', 'Veuillez vérifier vos mails et cliquer sur le lien afin de finaliser votre inscription');
            } else {
                $flash = new Flash('success', 'Une erreur est survenue, veuillez contacter le webmaster');
            }

            $flash->setFlash();

            $this->redirect('/');
        } else {
            $renderer = new Renderer(
                'signUp.twig',
                '../src/Controllers/Users/Views',
                ['title' => 'Inscription']
            );
            $renderer->render();
        }
    }
}
