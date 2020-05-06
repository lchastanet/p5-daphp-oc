<?php

namespace App\Model\News;

use App\lib\Entity;

class News extends Entity
{
    const AUTEUR_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;
    const CHAPO_INVALIDE = 4;
    protected $auteur;
    protected $titre;
    protected $chapo;
    protected $contenu;
    protected $dateAjout;
    protected $dateModif;

    public function isValid()
    {
        return !(empty($this->auteur) || empty($this->titre) || empty($this->contenu));
    }

    // SETTERS //

    public function setAuteur($auteur)
    {
        if (!is_string($auteur) || empty($auteur)) {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        }

        $this->auteur = $auteur;
    }

    public function setTitre($titre)
    {
        if (!is_string($titre) || empty($titre)) {
            $this->erreurs[] = self::TITRE_INVALIDE;
        }

        $this->titre = $titre;
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

    // GETTERS //

    public function auteur()
    {
        return $this->auteur;
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
}
