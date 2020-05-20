<?php

namespace App\lib;

class Authenticator
{
    public function checkCredentials($user, $password)
    {
        if (password_verify($password, $user->password())) {
            $this->setSessionInfo($user);

            return true;
        }

        return false;
    }

    public function checkAuth()
    {
        if (isset($_SESSION['auth']) && true == $_SESSION['auth']) {
            return true;
        }

        return false;
    }

    public static function getSessionInfo()
    {
        $currentSession = [];

        if (isset($_SESSION['auth']) && true == $_SESSION['auth']) {
            $currentSession['auth'] = $_SESSION['auth'];
        }

        if (isset($_SESSION['login'])) {
            $currentSession['login'] = $_SESSION['login'];
        }

        if (isset($_SESSION['idUser'])) {
            $currentSession['idUser'] = $_SESSION['idUser'];
        }

        if (isset($_SESSION['email'])) {
            $currentSession['email'] = $_SESSION['email'];
        }

        if (isset($_SESSION['role'])) {
            $currentSession['role'] = $_SESSION['role'];
        }

        return $currentSession;
    }

    private function setSessionInfo($user)
    {
        $_SESSION['login'] = $user->login();
        $_SESSION['idUser'] = $user->id();
        $_SESSION['email'] = $user->email();
        $_SESSION['auth'] = true;

        if (2 == $user->role()) {
            $_SESSION['role'] = 'user';
        } else {
            $_SESSION['role'] = 'admin';
        }
    }
}
