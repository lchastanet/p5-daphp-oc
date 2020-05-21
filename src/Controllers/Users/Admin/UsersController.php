<?php

namespace App\Controllers\Users\Admin;

use App\lib\Controller;
use App\lib\Renderer;
use App\lib\Session;

class UsersController extends Controller
{
  public function __construct()
  {
    parent::__construct('Users');
  }

  public function executeHome()
  {
    $nombreUsers = $this->manager->count();

    $newsManager = $this->managers->getManagerOf('News');
    $nombreNews = $newsManager->count();
    $commentsManager = $this->managers->getManagerOf('Comments');
    $nombreComments = $commentsManager->count();

    $renderer = new Renderer(
      'back',
      'home.twig',
      '../src/Controllers/Users/Admin/Views',
      [
        'nombreNews' => $nombreNews,
        'nombreComments' => $nombreComments,
        'nombreUsers' => $nombreUsers,
        'title' => 'Accueil'
      ]
    );
    $renderer->render();
  }

  public function executeLogout()
  {
    Session::destroySession();
    $this->redirect('/');
  }
}
