<?php

namespace App\lib;

abstract class Controller
{
    protected $managers;
    protected $manager;

    public function __construct($manager)
    {
        if (null != $manager) {
            $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
            $this->manager = $this->managers->getManagerOf($manager);
        }
    }

    public function executeError($errorCode)
    {
        $renderer = new Renderer(
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
