<?php

namespace App\lib;

use Symfony\Component\Yaml\Yaml;

class Config
{
    protected $basePath;
    protected $mailerCreds;
    protected $dataBaseCreds;

    public function __construct()
    {
        $config = Yaml::parseFile('../Config/config.yml');

        $this->basePath = $config['basePath'];
        $this->mailerCreds = $config['mailer'];
        $this->dataBaseCreds = $config['dataBase'];
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function getMailerCreds()
    {
        return $this->mailerCreds;
    }

    public function getDataBaseCreds()
    {
        return $this->dataBaseCreds;
    }
}
