<?php

namespace App\lib;

use Symfony\Component\Yaml\Yaml;

class Config
{
    protected $basePath;
    protected $siteURL;
    protected $mailerCreds;
    protected $dataBaseCreds;

    public function __construct()
    {
        $config = Yaml::parseFile('../Config/config.yml');

        $this->basePath = $config['basePath'];
        $this->siteURL = $config['siteURL'];
        $this->mailerCreds = $config['mailer'];
        $this->dataBaseCreds = $config['dataBase'];
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function getSiteURL()
    {
        return $this->siteURL;
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
