<?php
namespace App\Controllers\Users\Admin;

use App\lib\Controller;
use App\lib\Renderer;

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
      'home.twig',
      '../src/Controllers/Users/Admin/Views',
      ['nombreNews' => $nombreNews, 'nombreComments' => $nombreComments, 'nombreUsers' => $nombreUsers, 'title' => 'Accueil']  
    );
    $renderer->render();
  }

  public function executeLogout()
  {
    $_SESSION = [];
    $this->redirect('/');
  }
}