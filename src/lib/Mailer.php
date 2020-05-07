<?php

namespace App\lib;

class Mailer
{
    protected $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function sendContactMail($mail, $name, $subject, $message)
    {
        $sender = [$mail => $name];
        $recipient = $this->config->getMailerCreds();
        $recipient = [$recipient['mailAdresse'] => 'Site administrator'];

        return $this->sendMail($sender, $recipient, $subject, $message);
    }

    public function sendValidationMail($user)
    {
        $sender = $this->config->getMailerCreds();
        $sender = [$sender['mailAdresse'] => 'Site administrator'];
        $recipient = [$user->email() => $user->login()];
        $subject = 'Finalisez votre inscription sur le site!';
        $message = $this->config->getSiteURL() . $this->config->getBasePath() . '/validateAccount/' . $user->email() . '/' . $user->validationToken();

        return $this->sendMail($sender, $recipient, $subject, $message);
    }

    public function sendMail($sender, $recipient, $subject, $message)
    {
        $mailerCreds = $this->config->getMailerCreds();

        $transport = (new \Swift_SmtpTransport($mailerCreds['smtpServerAdresse'], $mailerCreds['smtpServerPort']))
            ->setUsername($mailerCreds['mailAdresse'])
            ->setPassword($mailerCreds['mailPassword']);

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message($subject))
            ->setFrom($sender)
            ->setTo($recipient)
            ->setBody($message);

        $result = $mailer->send($message);

        if ($result != 0) {
            return true;
        }
        return false;
    }
}
