<?php

namespace App\lib;

abstract class Controller
{
    protected $managers;
    protected $manager;
    protected $serverDatas;

    public function __construct($manager)
    {
        $this->serverDatas = $_SERVER;
        $requestURI = self::getServerData('REQUEST_URI');

        if ($requestURI != false) {
            if (preg_match("/admin/i", $requestURI)) {
                $authenticator = new Authenticator();
                $sessionInfo = $authenticator->getSessionInfo();

                if (!in_array('role', $sessionInfo) || $sessionInfo['role'] != 'admin') {
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
        $requestMethod = self::getServerData('REQUEST_METHOD');

        if ($requestMethod != false) {
            if ('POST' == $requestMethod) {
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
    }

    protected function redirect($destination)
    {
        $config = new Config();

        header('Location: ' . $config->getBasePath() . $destination);
    }

    private function getServerData($key)
    {
        if (array_key_exists($key, $this->serverDatas)) {
            return $this->serverDatas[$key];
        }
        var_dump($this->serverDatas[$key]);
        die;
        return false;
    }
}
