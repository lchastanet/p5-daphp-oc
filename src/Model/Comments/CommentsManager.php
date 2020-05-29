<?php

namespace App\Model\Comments;

use App\lib\Manager;

abstract class CommentsManager extends Manager
{
    /**
     * Méthode permettant d'enregistrer un commentaire.
     *
     * @param $comment Le commentaire à enregistrer
     */
    public function save(Comment $comment)
    {
        if ($comment->isValid()) {
            $comment->isNew() ? $this->add($comment) : $this->modify($comment);
        } else {
            throw new \RuntimeException('Le commentaire doit être validé pour être enregistré');
        }
    }

    /**
     * Méthode permettant de récupérer une liste de commentaires.
     *
     * @param $news La news sur laquelle on veut récupérer les commentaires
     *
     * @return array
     */
    abstract public function getListOf($news);

    /**
     * Méthode permettant d'obtenir un commentaire spécifique.
     *
     * @param $id L'identifiant du commentaire
     *
     * @return Comment
     */
    abstract public function get($idComment);

    /**
     * Méthode permettant de supprimer un commentaire.
     *
     * @param $id L'identifiant du commentaire à supprimer
     */
    abstract public function deleteComment($idComment);

    /**
     * Méthode permettant de supprimer tous les commentaires liés à une news.
     *
     * @param $news L'identifiant de la news dont les commentaires doivent être supprimés
     */
    abstract public function deleteFromNews($news);

    /**
     * Méthode renvoyant le nombre de commentaires total.
     *
     * @return int
     */
    abstract public function count();


    /**
     * Méthode permettant d'obtenir une liste de commentaires.
     *
     * @param $validated bool Un booléen indiquant le type de commentaires a retourner
     *
     * @return Array 
     */
    abstract public function getAdminList($validated);

    /**
     * Méthode permettant de valider un commentaire.
     *
     * @param $idComment int L'indentifiant du commentaire à  valider
     */
    abstract public function validate($idComment);

    /**
     * Méthode permettant d'ajouter un commentaire.
     *
     * @param $comment Le commentaire à ajouter
     */
    abstract protected function add(Comment $comment);

    /**
     * Méthode permettant de modifier un commentaire.
     *
     * @param $comment Le commentaire à modifier
     */
    abstract protected function modify(Comment $comment);
}
