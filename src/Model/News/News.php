<?php

namespace App\Model\News;

use App\lib\Entity;

class News extends Entity
{
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
            $this->erreurs[] = "idUser invalide";
        }

        $this->idUser = $idUser;
    }

    public function setTitre($titre)
    {
        if (!is_string($titre) || empty($titre)) {
            $this->erreurs[] = "titre invalide";
        }

        $this->titre = $titre;
    }

    public function setlogin($login)
    {
        if (!is_string($login) || empty($login)) {
            $this->erreurs[] = "login invalide";
        }

        $this->login = $login;
    }

    public function setChapo($chapo)
    {
        if (!is_string($chapo) || empty($chapo)) {
            $this->erreurs[] = "chapo invalide";
        }

        $this->chapo = $chapo;
    }

    public function setContenu($contenu)
    {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreurs[] = "contenu invalide";
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

    public function setId($idNews)
    {
        $this->id = $idNews;
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
