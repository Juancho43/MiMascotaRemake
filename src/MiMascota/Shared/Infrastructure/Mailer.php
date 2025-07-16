<?php

namespace App\MiMascota\Shared\Infrastructure;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{

    public function __construct(private MailerInterface $mailer,)
    {
    }
    public function sendEmail(string $from,string $email, string $subject, string $message)
    {
        $email = (new Email())
            ->from($from)
            ->to($email)
            ->subject($subject)
            ->text($message);


        $this->mailer->send($email);
    }
}
