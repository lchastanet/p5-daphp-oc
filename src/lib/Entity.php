<?php

namespace App\lib;

abstract class Entity
{
    use Hydrator;
    protected $erreurs = [];
    protected $id;

    public function __construct(array $donnees = [])
    {
        if (!empty($donnees)) {
            $this->hydrate($donnees);
        }
    }

    public function isNew()
    {
        return empty($this->id);
    }

    // SETTERS

    public function setId($idEntity)
    {
        $this->id = (int) $idEntity;
    }

    // GETTERS
    public function erreurs()
    {
        return $this->erreurs;
    }

    public function id()
    {
        return $this->id;
    }
}
