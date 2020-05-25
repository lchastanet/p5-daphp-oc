<?php

namespace App\Model\Users;

use App\lib\Manager;

abstract class UsersManager extends Manager
{
    /**
     * Méthode permettant d'enregistrer un commentaire.
     *
     * @param $comment Le commentaire à enregistrer
     */
    public function save(User $user)
    {
        if ($user->isValid()) {
            $this->add($user);
        } else {
            throw new \RuntimeException('L\'utilisateur doit être validé pour être enregistré');
        }
    }

    /**
     * Méthode retournant un utilisateur ou null.
     *
     * @param $email string L'adresse email de l'utilisateur recherché.
     *
     * @return User L'utilisateur 
     */
    abstract public function getByEmail($email);

    /**
     * Méthode renvoyant le nombre de news total.
     *
     * @return int
     */
    abstract public function count();

    /**
     * Méthode retournant une liste de news demandée.
     *
     * @return array La liste des utilisateurs. Chaque entrée est une instance de User.
     */
    abstract public function getAdminList();

    /**
     * Méthode validant le compte de l'utilisateur.
     *
     * @param $idUser int L'id de l'utilisateur.
     */
    abstract public function validateAccount($idUser);

    /**
     * Méthode permettant d'ajouter un utilisateur.
     *
     * @param $user User L'utilisateur à ajouter
     */
    abstract protected function add(User $user);
}
