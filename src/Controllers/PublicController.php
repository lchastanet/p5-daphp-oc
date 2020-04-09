<?php
namespace App\Controllers;

use App\lib\Renderer;
use App\lib\Controller;

class PublicController extends Controller
{
  //Controller servant à afficher les pages "hors module"
    public function __construct()
    {
      parent::__construct(null);
    }
}