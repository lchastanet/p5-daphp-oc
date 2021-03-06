<?php

namespace App\Controllers\Comments\Admin;

use App\lib\Controller;
use App\lib\Renderer;

class CommentsController extends Controller
{
    public function __construct()
    {
        parent::__construct('Comments');
    }

    public function executeAdminList()
    {
        $listUnvalidated = $this->manager->getAdminList(false);
        $listValidated = $this->manager->getAdminList(true);

        $renderer = new Renderer(
            'back',
            'list.twig',
            '../src/Controllers/Comments/Admin/Views',
            [
                'unvalidatedComments' => $listUnvalidated,
                'validatedComments' => $listValidated,
                'title' => 'Gestion des commentaires'
            ]
        );
        $renderer->render();
    }

    public function executeCommentValidation($idComment)
    {
        $this->manager->validate($idComment);
        $this->redirect('/admin/listComments');
    }

    public function executeDelete($idComment)
    {
        $this->manager->deleteComment($idComment);
        $this->redirect('/admin/listComments');
    }
}
