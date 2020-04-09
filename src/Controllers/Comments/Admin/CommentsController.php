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
        $listCommentsUnvalidated = $this->manager->getAdminList(false);
        $listCommentsValidated = $this->manager->getAdminList(true);

        $renderer = new Renderer(
            'list.twig',
            '../src/Controllers/Comments/Admin/Views',
            ['unvalidatedComments' => $listCommentsUnvalidated, 'validatedComments' => $listCommentsValidated, 'title' => 'Gestion des commentaires']
        );
        $renderer->render();
    }

    public function executeCommentValidation($id)
    {
        $this->manager->validate($id);
        $this->redirect('/admin/listComments');
    }

    public function executeDelete($id)
    {
        $this->manager->delete($id);
        $this->redirect('/admin/listComments');
    }
}
