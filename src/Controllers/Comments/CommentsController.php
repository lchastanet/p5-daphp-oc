<?php

namespace App\Controllers\Comments;

use App\lib\Controller;
use App\Model\Comments\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        parent::__construct('Comments');
    }

    public function executeInsert($idNews)
    {
        $comment = new Comment([
            'news' => $idNews,
            'auteur' => $_SESSION['login'],
            'contenu' => $_POST['comment'],
            'validated' => false,
        ]);

        $this->manager->save($comment);

        $this->redirect('/news/'.$idNews);
    }

    public function executeList($idNews)
    {
        return $this->manager->getListOf($idNews);
    }
}
