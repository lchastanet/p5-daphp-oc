<?php

namespace App\Controllers\News;

use App\Controllers\Comments\CommentsController;
use App\lib\Controller;
use App\lib\Renderer;

class NewsController extends Controller
{
    public function __construct()
    {
        parent::__construct('News');
    }

    public function executeList()
    {
        $listeNews = $this->manager->getList(0, 5);

        foreach ($listeNews as $news) {
            if (strlen($news->contenu()) > 200) {
                $debut = substr($news->contenu(), 0, 200);
                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                $news->setContenu($debut);
            }
        }
        $renderer = new Renderer(
            'front',
            'home.twig',
            '../src/Controllers/News/Views',
            ['news' => $listeNews, 'title' => 'Accueil']
        );
        $renderer->render();
    }

    public function executeShow($id)
    {
        $news = $this->manager->getUnique($id);

        if (empty($news)) {
            $this->executeError(404);
        }

        $controller = new CommentsController();
        $comments = $controller->executeList($id);

        $renderer = new Renderer(
            'front',
            'show.twig',
            ['../src/Controllers/News/Views', '../src/Controllers/Comments/Views'],
            ['news' => $news, 'comments' => $comments, 'title' => $news->titre()]
        );
        $renderer->render();
    }
}
