<?php

namespace App\lib;

class PDOFactory
{
    public static function getMysqlConnexion()
    {
        $config = new Config();
        $dbCreds = $config->getDataBaseCreds();
        $db = new \PDO('mysql:host='.$dbCreds['hostName'].';dbname='.$dbCreds['dbName'], $dbCreds['login'], $dbCreds['password']);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
