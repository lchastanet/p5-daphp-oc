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
        $_SESSION['flash'] = ['type' => $this->type, 'message' => $this->message];
    }

    public static function getFlash()
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);

            return $flash;
        }

        return null;
    }
}
