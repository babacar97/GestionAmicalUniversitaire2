<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;


class MailerService
{

    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($code, $to): void
    {


        $email = (new Email())
            ->from('babacar.ndiaye20@uvs.edu.sn')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Comfirmation de vote')
            // ->text()
            ->html('Veuillez confirmer votre vote en remplissant ce code ' . $code . ' sur le formulaire ');

        $this->mailer->send($email);

        // ...
    }
}
