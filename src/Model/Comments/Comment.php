<?php

namespace App\Model\Comments;

use App\lib\Entity;

class Comment extends Entity
{
    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;
    protected $news;
    protected $auteur;
    protected $contenu;
    protected $date;
    protected $validated;

    public function isValid()
    {
        return !(empty($this->auteur) || empty($this->contenu));
    }

    public function setNews($news)
    {
        $this->news = (int) $news;
    }

    public function setAuteur($auteur)
    {
        if (!is_string($auteur) || empty($auteur)) {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        }

        $this->auteur = $auteur;
    }

    public function setContenu($contenu)
    {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        }

        $this->contenu = $contenu;
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

    public function auteur()
    {
        return $this->auteur;
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
