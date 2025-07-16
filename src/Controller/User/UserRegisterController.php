<?php

namespace App\Controller\User;

use App\MiMascota\Locations\Application\LocationManager;
use App\MiMascota\Locations\Infrastructure\ReverseGeocodeClient;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Users\Application\UserRegister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class UserRegisterController extends AbstractController
{
    use ApiResponseTrait;
    public function __construct(
        private MailerInterface $mailer,

    )
    {

    }
    #[Route('/user/register', name: 'user_register', methods:  ['POST'])]
    public function __invoke(
        Request         $request,
        UserRegister    $creator,
    ): Response
    {
        $data = $request->toArray();


        $user = $creator->__invoke(
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['latitude'] ?? '',
            $data['longitude'] ?? '',
        );
        $code = $user->getValidationCode();

        $text = sprintf("Por favor, valida tu cuenta con el siguiente código %s", $code);

        $email = (new Email())
            ->from($_ENV['SUPPORT_EMAIL'])
            ->to($user->getEmail())
            ->subject('Validar cuenta')
            ->text($text);


        $this->mailer->send($email);

        return $this->successResponse($user, "Usuario creado correctamente", Response::HTTP_CREATED);
    }
}
