<?php

namespace App\Model\News;

use App\lib\Entity;

class News extends Entity
{
    const LOGIN_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;
    const CHAPO_INVALIDE = 4;
    protected $id;
    protected $idUser;
    protected $login;
    protected $titre;
    protected $chapo;
    protected $contenu;
    protected $dateAjout;
    protected $dateModif;

    public function isValid()
    {
        return !(empty($this->idUser) || empty($this->titre) || empty($this->chapo) || empty($this->contenu));
    }

    // SETTERS //

    public function setIdUser($idUser)
    {
        if (!is_numeric($idUser) || empty($idUser)) {
            $this->erreurs[] = self::LOGIN_INVALIDE;
        }

        $this->idUser = $idUser;
    }

    public function setTitre($titre)
    {
        if (!is_string($titre) || empty($titre)) {
            $this->erreurs[] = self::TITRE_INVALIDE;
        }

        $this->titre = $titre;
    }

    public function setlogin($login)
    {
        if (!is_string($login) || empty($login)) {
            $this->erreurs[] = self::LOGIN_INVALIDE;
        }

        $this->login = $login;
    }

    public function setChapo($chapo)
    {
        if (!is_string($chapo) || empty($chapo)) {
            $this->erreurs[] = self::CHAPO_INVALIDE;
        }

        $this->chapo = $chapo;
    }

    public function setContenu($contenu)
    {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        }

        $this->contenu = $contenu;
    }

    public function setDateAjout(\DateTime $dateAjout)
    {
        $this->dateAjout = $dateAjout;
    }

    public function setDateModif(\DateTime $dateModif)
    {
        $this->dateModif = $dateModif;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    // GETTERS //

    public function idUser()
    {
        return $this->idUser;
    }

    public function login()
    {
        return $this->login;
    }

    public function titre()
    {
        return $this->titre;
    }

    public function chapo()
    {
        return $this->chapo;
    }

    public function contenu()
    {
        return $this->contenu;
    }

    public function dateAjout()
    {
        return $this->dateAjout;
    }

    public function dateModif()
    {
        return $this->dateModif;
    }

    public function id()
    {
        return $this->id;
    }
}
