<?php

namespace App\lib;

abstract class Controller
{
    protected $managers;
    protected $manager;

    public function __construct($manager)
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            if (preg_match("/admin/i", $_SERVER['REQUEST_URI'])) {
                $authenticator = new Authenticator();
                $sessionInfo = $authenticator->getSessionInfo();

                if ($sessionInfo['role'] != 'admin') {
                    $this->executeError(401);
                }
            }
        }

        if (null != $manager) {
            $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
            $this->manager = $this->managers->getManagerOf($manager);
        }
    }

    protected function isPostMethod()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            if ('POST' == $_SERVER['REQUEST_METHOD']) {
                return true;
            }
            return false;
        }
    }

    public function executeError($errorCode)
    {
        $renderer = new Renderer(
            'front',
            $errorCode . '.twig',
            '../Errors',
            ['title' => $errorCode],
            $errorCode
        );
        $renderer->render();
        exit;
    }

    protected function redirect($destination)
    {
        $config = new Config();

        header('Location: ' . $config->getBasePath() . $destination);
        exit;
    }
}
