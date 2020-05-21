<?php

namespace App\lib;

class Session
{
    public static function getSessionDatas()
    {
        return $_SESSION;
    }

    public static function setSessionData($key, $val)
    {
        if (!empty($key) && !empty($val)) {
            $_SESSION[$key] = $val;
        }
    }

    public static function deleteSessionData($key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroySession()
    {
        $_SESSION = [];
        session_destroy();
    }
}
