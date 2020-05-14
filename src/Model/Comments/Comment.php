<?php

namespace App\Model\Comments;

use App\lib\Entity;

class Comment extends Entity
{
    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;
    protected $news;
    protected $idUser;
    protected $login;
    protected $contenu;
    protected $date;
    protected $validated;

    public function isValid()
    {
        return !(empty($this->idUser) || empty($this->contenu));
    }

    public function setNews($news)
    {
        $this->news = (int) $news;
    }

    public function setIdUser($idUser)
    {
        if (!is_numeric($idUser) || empty($idUser)) {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        }

        $this->idUser = $idUser;
    }

    public function setContenu($contenu)
    {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        }

        $this->contenu = $contenu;
    }

    public function setLogin($login)
    {
        if (!is_string($login) || empty($login)) {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        }

        $this->contenu = $login;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    public function news()
    {
        return $this->news;
    }

    public function idUser()
    {
        return $this->idUser;
    }

    public function login()
    {
        return $this->login;
    }

    public function contenu()
    {
        return $this->contenu;
    }

    public function date()
    {
        return $this->date;
    }

    public function validated()
    {
        return $this->validated;
    }
}
