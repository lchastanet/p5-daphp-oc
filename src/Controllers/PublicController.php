<?php

namespace App\Controllers;

use App\lib\Controller;
use App\lib\Mailer;
use App\lib\Flash;
use App\lib\Validators\PostedValuesValidator;


class PublicController extends Controller
{
  public function __construct()
  {
    parent::__construct(null);
  }

  public function executeContactForm()
  {
    if ($this->isPostMethod()) {
      $validator = new PostedValuesValidator('Formulaire incomplet, veuillez recommencer');
      $postedValues = $validator->isValid(['name', 'email', 'subject', 'message']);

      if (null != $postedValues) {
        $mailer = new Mailer();

        if ($mailer->sendContactMail($postedValues['email'], $postedValues['name'], $postedValues['subject'], $postedValues['message'])) {
          $flash = new Flash('success', 'Votre message à bien été envoyé!');
          $flash->setFlash();
          $this->redirect('/');
        } else {
          $flash = new Flash('danger', 'Une erreur est survenue, veuillez contacter l\'administarteur');
          $flash->setFlash();
          $this->executeError(500);
        }
      } else {
        $flash = new Flash('danger', 'Formulaire incomplet, veuillez recommencer');
        $flash->setFlash();
        $this->redirect('/');
      }
    }
  }
}
