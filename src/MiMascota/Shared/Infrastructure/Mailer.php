<?php

namespace App\MiMascota\Shared\Infrastructure;

use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{
    use ApiResponseTrait;
    public function __construct(private MailerInterface $mailer,)
    {
    }
    public function sendEmail(string $from,string $email, string $subject, string $message, mixed $html = ''): JsonResponse | bool
    {
        try {
            $email = (new Email())
                ->from($from)
                ->to($email)
                ->subject($subject)
                ->text($message)
                ->html($html);

            $this->mailer->send($email);
            return true;
        } catch (TransportExceptionInterface $exception){
            return $this->errorResponse("Error al enviar el correo: " . $exception->getMessage());
        }
    }
}
