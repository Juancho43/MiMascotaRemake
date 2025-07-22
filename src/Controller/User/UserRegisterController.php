<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\Infrastructure\Mailer;
use App\MiMascota\Shared\SerializerTrait;
use App\MiMascota\Users\Application\UserRegister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRegisterController extends AbstractController
{
    use ApiResponseTrait,SerializerTrait;
    public function __construct(private readonly Mailer $mailer)
    {
    }

    #[Route('/user/register', name: 'user_register', methods:  ['POST'])]
    public function __invoke(Request $request, UserRegister $creator): Response
    {
        try {
            $data = $request->toArray();
            $user = $creator->__invoke(
                $data['name'] ?? '',
                $data['telephone'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? '',
                $data['latitude'] ?? '',
                $data['longitude'] ?? '',
            );

            $code = $user->getValidationCode();
            $this->mailer->sendEmail(
                $_ENV['SUPPORT_EMAIL'],
                $user->getEmail(),
                'Validar cuenta',
                sprintf("Por favor, valida tu cuenta con el siguiente código %s", $code)
            );

            return $this->successResponse($user, "Usuario creado correctamente", Response::HTTP_CREATED);
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }


    }
}
