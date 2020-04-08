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

    public function execute404()
    {
        $renderer = new Renderer(
            '404.twig',
            '../Errors',
            ['title' => '404'],
            404
        );
        $renderer->render();
        exit;
    }

    protected function redirect($destination)
    {
        $config = new Config();

        header('Location: '.$config->getBasePath().$destination);
        exit;
    }
}
