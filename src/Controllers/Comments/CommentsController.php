<?php

namespace App\Controllers\Comments;

use App\lib\Controller;
use App\lib\Flash;
use App\Model\Comments\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        parent::__construct('Comments');
    }

    public function executeInsert($idNews)
    {
        if ($this->isPostMethod()) {
            $comment = new Comment([
                'news' => $idNews,
                'auteur' => $_SESSION['login'],
                'idUser' => $_SESSION['idUser'],
                'contenu' => $_POST['comment'],
                'validated' => false,
            ]);

            $this->manager->save($comment);

            $flash = new Flash('success', 'Votre commentaire à bien été enregisté, il sera publié après validation!');
            $flash->setFlash();

            $this->redirect('/news/' . $idNews);
        }
    }

    public function executeList($idNews)
    {
        return $this->manager->getListOf($idNews);
    }
}
