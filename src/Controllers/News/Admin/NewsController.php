<?php

namespace App\Controllers\News\Admin;

use App\lib\Controller;
use App\lib\Renderer;
use App\lib\Flash;
use App\lib\Validators\MaxLengthValidator;
use App\lib\Validators\NotNullValidator;
use App\Model\News\News;
use App\lib\Validators\PostedValuesValidator;

class NewsController extends Controller
{
    public function __construct()
    {
        parent::__construct('News');
    }

    public function executeList()
    {
        $listeNews = $this->manager->getList();
        $nombreNews = $this->manager->count();

        $renderer = new Renderer(
            'back',
            'list.twig',
            '../src/Controllers/News/Admin/Views',
            ['nombreNews' => $nombreNews, 'listeNews' => $listeNews, 'title' => 'Gestion des articles']
        );
        $renderer->render();
    }

    public function executeAddNews()
    {
        if ($this->isPostMethod()) {
            $validator = new PostedValuesValidator('Un des champs est resté vide');
            $postedValues = $validator->isValid(['titre', 'chapo', 'contenu', 'idUser']);

            if (null != $postedValues) {
                $validator = new NotNullValidator('Un des champs est vide');

                if (
                    $validator->isValid($postedValues['titre']) &&
                    $validator->isValid($postedValues['chapo']) &&
                    $validator->isValid($postedValues['contenu']) &&
                    $validator->isValid($postedValues['idUser'])
                ) {
                    $validator = new MaxLengthValidator('La champs chapo doit faire 200 caractères maximum', 200);

                    if ($validator->isValid($postedValues['chapo'])) {
                        $news = new News([
                            'titre' => $postedValues['titre'],
                            'chapo' => $postedValues['chapo'],
                            'idUser' => (int) $postedValues['idUser'],
                            'contenu' => $postedValues['contenu'],
                        ]);

                        $this->manager->save($news);

                        $flash = new Flash('success', 'La news à bien été ajoutée');
                        $flash->setFlash();

                        $this->redirect('/admin/listNews');
                    } else {
                        $flash = new Flash('danger', $validator->errorMessage());
                        $flash->setFlash();

                        $this->redirect('/admin/listNews');
                    }
                } else {
                    $flash = new Flash('danger', 'Un des champs est resté vide');
                    $flash->setFlash();

                    $this->redirect('/admin/listNews');
                }
            } else {
                $flash = new Flash('danger', 'Un des champs est resté vide');
                $flash->setFlash();

                $this->redirect('/admin/listNews');
            }
        } else {
            $manager = $this->managers->getManagerOf('Users');

            $users = $manager->getAdminList();

            $renderer = new Renderer(
                'back',
                'insert.twig',
                '../src/Controllers/News/Admin/Views',
                ['title' => 'Ajouter un article', 'users' => $users]
            );
            $renderer->render();
        }
    }

    public function executeUpdateNews($id)
    {
        if ($this->isPostMethod()) {
            $validator = new PostedValuesValidator('Un des champs est resté vide');
            $postedValues = $validator->isValid(['titre', 'chapo', 'contenu', 'idUser']);

            if (null != $postedValues) {
                $validator = new NotNullValidator('Un des champs est vide');

                if (
                    $validator->isValid($postedValues['titre']) &&
                    $validator->isValid($postedValues['chapo']) &&
                    $validator->isValid($postedValues['contenu']) &&
                    $validator->isValid($postedValues['idUser'])
                ) {
                    $validator = new MaxLengthValidator('La champs chapo doit faire 200 caractères maximum', 200);

                    if ($validator->isValid($postedValues['chapo'])) {
                        $news = new News([
                            'id' => $id,
                            'titre' => $postedValues['titre'],
                            'chapo' => $postedValues['chapo'],
                            'idUser' => (int) $postedValues['idUser'],
                            'contenu' => $postedValues['contenu'],
                        ]);

                        $this->manager->save($news);

                        $flash = new Flash('success', 'La news à bien été modifiée');
                        $flash->setFlash();

                        $this->redirect('/admin/listNews');
                    } else {
                        $flash = new Flash('danger', $validator->errorMessage());
                        $flash->setFlash();

                        $this->redirect('/admin/updateNews/' . $id);
                    }
                } else {
                    $flash = new Flash('danger', 'Un des champs est resté vide');
                    $flash->setFlash();

                    $this->redirect('/admin/updateNews/' . $id);
                }
            } else {
                $flash = new Flash('danger', 'Un des champs est resté vide');
                $flash->setFlash();

                $this->redirect('/admin/updateNews/' . $id);
            }
        } else {
            $news = $this->manager->getUnique($id);

            $manager = $this->managers->getManagerOf('Users');

            $users = $manager->getAdminList();

            $renderer = new Renderer(
                'back',
                'update.twig',
                '../src/Controllers/News/Admin/Views',
                ['title' => 'Modifier un article', 'news' => $news, 'users' => $users]
            );
            $renderer->render();
        }
    }

    public function executeDelete($id)
    {
        $this->manager->delete($id);
        $this->redirect('/admin/listNews');
    }
}
