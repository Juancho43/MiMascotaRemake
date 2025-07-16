<?php

namespace App\Controller\User;

use App\MiMascota\Locations\Application\LocationManager;
use App\MiMascota\Locations\Infrastructure\ReverseGeocodeClient;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\Infrastructure\Mailer;
use App\MiMascota\Shared\SerializerTrait;
use App\MiMascota\Users\Application\UserRegister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class UserRegisterController extends AbstractController
{
    use ApiResponseTrait,SerializerTrait;
    public function __construct(
        private Mailer $mailer,

    )
    {

    }
    #[Route('/user/register', name: 'user_register', methods:  ['POST'])]
    public function __invoke(Request $request, UserRegister $creator): Response
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
        $this->mailer->sendEmail(
            $_ENV['SUPPORT_EMAIL'],
            $user->getEmail(),
            'Validar cuenta',
            $text
        );
        
        return $this->successResponse($this->serialize($user), "Usuario creado correctamente", Response::HTTP_CREATED);
    }
}
