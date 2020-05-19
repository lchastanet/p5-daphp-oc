<?php

namespace App\Controllers\Users;

use App\lib\Authenticator;
use App\lib\Controller;
use App\lib\Flash;
use App\lib\Validators\PostedValuesValidator;
use App\lib\Mailer;
use App\lib\Renderer;
use App\lib\Validators\EmailValidator;
use App\lib\Validators\NotNullValidator;
use App\lib\Validators\MinLengthValidator;
use App\Model\Users\User;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct('Users');
    }

    public function executeSignIn()
    {
        if ($this->isPostMethod()) {
            $validator = new PostedValuesValidator('Un des champs est resté vide');
            $postedValues = $validator->isValid(['email', 'password']);

            if (null != $postedValues) {
                $validator = new EmailValidator('Format de l\' adresse mail Incorrecte');
                if ($validator->isValid($postedValues['email'])) {
                    $email = $postedValues['email'];
                    $validator = new NotNullValidator('Le mot de passe est vide');

                    if ($validator->isValid($postedValues['password'])) {
                        $password = $postedValues['password'];

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
                        $flash = new Flash('danger', $validator->errorMessage());
                        $flash->setFlash();
                        $this->redirect('/signIn');
                    }
                } else {
                    $flash = new Flash('danger', $validator->errorMessage());
                    $flash->setFlash();
                    $this->redirect('/signIn');
                }
            } else {
                $flash = new Flash('danger', $validator->errorMessage());
                $flash->setFlash();
                $this->redirect('/signIn');
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
        if ($this->isPostMethod()) {
            $validator = new PostedValuesValidator('Formulaire incomplet, veuillez recommencer');
            $postedValues = $validator->isValid(['login', 'email', 'password', 'passwordValidation']);

            if (null != $postedValues) {
                $validator = new EmailValidator('Format d\'adresse email incorrecte');

                if ($validator->isValid($postedValues['email'])) {
                    $email = $postedValues['email'];
                    $mailExist = $this->manager->getByEmail($email);

                    if ($mailExist == null) {
                        $validator = new NotNullValidator('Formulaire incomplet, veuillez recommencer');

                        if (
                            $validator->isValid($postedValues['login']) &&
                            $validator->isValid($postedValues['password']) &&
                            $validator->isValid($postedValues['passwordValidation'])
                        ) {
                            $validator = new MinLengthValidator('Votre login doit contenir 3 caractères minimum', 3);

                            if ($validator->isValid($postedValues['login'])) {
                                $login = $postedValues['login'];
                                $validator = new MinLengthValidator('Votre mot de passe doit contenir 3 caractères minimum', 3);

                                if ($validator->isValid($postedValues['password'])) {
                                    $password = $postedValues['password'];
                                    if ($password === $postedValues['passwordValidation']) {
                                        $user = new User([
                                            'login' => $login,
                                            'email' => $email,
                                            'password' => password_hash($password, PASSWORD_DEFAULT),
                                            'validated' => 0,
                                            'role' => 2,
                                        ]);

                                        $user->setValidationToken(bin2hex(random_bytes(32)));

                                        $this->manager->save($user);

                                        $mailer = new Mailer();

                                        if ($mailer->sendValidationMail($user)) {
                                            $flash = new Flash('success', 'Veuillez vérifier vos mails et cliquer sur le lien afin de finaliser votre inscription');
                                            $flash->setFlash();
                                            $this->redirect('/signIn');
                                        } else {
                                            $flash = new Flash('danger', 'Une erreur est survenue, veuillez contacter le webmaster');
                                            $flash->setFlash();
                                            $this->executeError(500);
                                        }
                                    } else {
                                        $flash = new Flash('danger', 'Les deux mots de passe ne correspondent pas');
                                        $flash->setFlash();

                                        $this->redirect('/signUp');
                                    }
                                } else {
                                    $flash = new Flash('danger', $validator->errorMessage());
                                    $flash->setFlash();

                                    $this->redirect('/signUp');
                                }
                            } else {
                                $flash = new Flash('danger', $validator->errorMessage());
                                $flash->setFlash();

                                $this->redirect('/signUp');
                            }
                        } else {
                            $flash = new Flash('danger', $validator->errorMessage());
                            $flash->setFlash();

                            $this->redirect('/signUp');
                        }
                    } else {
                        $flash = new Flash('danger', 'Cette adresse mail est déjà utilisée');
                        $flash->setFlash();

                        $this->redirect('/signUp');
                    }
                } else {
                    $flash = new Flash('danger', $validator->errorMessage());
                    $flash->setFlash();

                    $this->redirect('/signUp');
                }
            } else {
                $flash = new Flash('danger', $validator->errorMessage());
                $flash->setFlash();

                $this->redirect('/signUp');
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
                if ($user->validationToken() === $validationToken) {
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
