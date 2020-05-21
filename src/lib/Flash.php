<?php

namespace App\lib;

class Flash
{
    protected $type;
    protected $message;

    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function setFlash()
    {
        Session::setSessionData('flash', ['type' => $this->type, 'message' => $this->message]);
    }

    public static function getFlash()
    {
        $sessionDatas = Session::getSessionDatas();

        if (array_key_exists('flash', $sessionDatas)) {
            $flash = $sessionDatas['flash'];
            Session::deleteSessionData('flash');

            return $flash;
        }

        return null;
    }
}
