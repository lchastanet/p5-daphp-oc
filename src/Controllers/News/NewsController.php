<?php

namespace App\Controllers\News;

use App\Controllers\Comments\CommentsController;
use App\lib\Authenticator;
use App\lib\Controller;
use App\lib\Renderer;

class NewsController extends Controller
{
    public function __construct()
    {
        parent::__construct('News');
    }

    public function executeList($index)
    {
        $offset = ($index - 1) * 5;

        $listeNews = $this->manager->getList($offset, 5);

        if (!empty($listeNews)) {
            $nombreNews = $this->manager->count();
            $nombrePages = ceil($nombreNews / 5);

            $renderer = new Renderer(
                'front',
                'list.twig',
                '../src/Controllers/News/Views',
                [
                    'news' => $listeNews,
                    'title' => 'Tous les articles',
                    'currentPage' => $index,
                    'nombrePages' => $nombrePages
                ]
            );
            $renderer->render();
        } else {
            $this->executeError(404);
        }
    }

    public function executeHome()
    {
        $sessionInfo = Authenticator::getSessionInfo();
        $listeNews = $this->manager->getList(0, 5);

        $renderer = new Renderer(
            'front',
            'home.twig',
            '../src/Controllers/News/Views',
            [
                'news' => $listeNews,
                'title' => 'Accueil',
                'token' => $sessionInfo['token']
            ]
        );
        $renderer->render();
    }

    public function executeShow($id)
    {
        $news = $this->manager->getUnique($id);

        if (empty($news)) {
            $this->executeError(404);
        }

        $sessionInfo = Authenticator::getSessionInfo();
        $controller = new CommentsController();
        $comments = $controller->executeList($id);

        $renderer = new Renderer(
            'front',
            'show.twig',
            ['../src/Controllers/News/Views', '../src/Controllers/Comments/Views'],
            [
                'news' => $news,
                'comments' => $comments,
                'title' => $news->titre(),
                'token' => $sessionInfo['token']
            ]
        );
        $renderer->render();
    }
}
