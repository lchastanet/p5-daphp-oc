<?php

namespace App\Controllers\Comments;

use App\lib\Controller;
use App\lib\Flash;
use App\lib\Authenticator;
use App\lib\Validators\NotNullValidator;
use App\lib\Validators\PostedValuesValidator;
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
            $validator = new PostedValuesValidator('Le champs est resté vide');
            $postedValue = $validator->isValid(['comment']);

            if (null != $postedValue) {
                $validator = new NotNullValidator('Le champs est vide...');

                if ($validator->isValid($postedValue)) {
                    $authenticator = new Authenticator();

                    if (true == $authenticator->checkAuth()) {
                        $sessionInfo = $authenticator::getSessionInfo();

                        $comment = new Comment([
                            'news' => $idNews,
                            'auteur' => $sessionInfo['login'],
                            'idUser' => $sessionInfo['idUser'],
                            'contenu' => $postedValue['comment'],
                            'validated' => false,
                        ]);

                        $this->manager->save($comment);

                        $flash = new Flash('success', 'Votre commentaire à bien été enregisté, il sera publié après validation!');
                        $flash->setFlash();

                        $this->redirect('/news/' . $idNews);
                    } else {
                        $flash = new Flash('danger', 'Vous devez être connecter si vous souhaitez ajouter un commentaire');
                        $flash->setFlash();

                        $this->redirect('/news/' . $idNews);
                    }
                } else {
                    $flash = new Flash('danger', 'Un des champs est resté vide');
                    $flash->setFlash();

                    $this->redirect('/news/' . $idNews);
                }
            } else {
                $flash = new Flash('danger', 'Un des champs est resté vide');
                $flash->setFlash();

                $this->redirect('/news/' . $idNews);
            }
        } else {
            $this->redirect('/news/' . $idNews);
        }
    }

    public function executeList($idNews)
    {
        return $this->manager->getListOf($idNews);
    }
}
