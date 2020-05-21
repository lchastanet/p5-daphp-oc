<?php

namespace App\lib;

class Authenticator
{
    public static function initSession()
    {
        session_start();

        if (!array_key_exists('token', Session::getSessionDatas())) {
            Session::setSessionData('token', bin2hex(random_bytes(32)));
        }
    }

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
        $session = Session::getSessionDatas();

        if (isset($session['auth']) && true == $session['auth']) {
            return true;
        }

        return false;
    }

    public static function getSessionInfo()
    {
        $datas = [];

        $currentSession = Session::getSessionDatas();
        $keys = ['auth', 'login', 'idUser', 'email', 'role', 'token'];

        foreach ($keys as $value) {
            if (array_key_exists($value, $currentSession)) {
                $datas[$value] = $currentSession[$value];
            }
        }
        return $datas;
    }

    private function setSessionInfo($user)
    {
        Session::setSessionData('login', $user->login());
        Session::setSessionData('idUser', $user->id());
        Session::setSessionData('email', $user->email());
        Session::setSessionData('auth', true);

        if (2 == $user->role()) {
            Session::setSessionData('role', 'user');
        } else {
            Session::setSessionData('role', 'admin');
        }
    }
}
