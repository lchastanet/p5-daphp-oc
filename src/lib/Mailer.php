<?php

namespace App\lib;

class Mailer
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function sendMail()
    {
        $config = new Config();
        $mailerCreds = $config->getMailerCreds();

        $transport = (new \Swift_SmtpTransport($mailerCreds['smtpServerAdresse'], $mailerCreds['smtpServerPort']))
            ->setUsername($mailerCreds['mailAdresse'])
            ->setPassword($mailerCreds['mailPassword']);

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Finalisez votre inscription sur le site!'))
            ->setFrom([$mailerCreds['mailAdresse'] => 'Site administrator'])
            ->setTo([$this->user->email() => $this->user->login()])
            ->setBody($config->getSiteURL() . $config->getBasePath() . '/validateAccount/' . $this->user->email() . '/' . $this->user->validationToken());

        $result = $mailer->send($message);

        if ($result != 0) {
            return true;
        }
        return false;
    }
}
