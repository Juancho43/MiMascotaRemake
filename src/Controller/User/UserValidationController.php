<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Users\Application\Command\ValidateUserCommand;
use App\MiMascota\Users\Application\UserValidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserValidationController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/user/validate', name: 'user_validate', methods: ['POST'])]
    public function __invoke(Request $request, UserValidate $userValidate) : JsonResponse
    {
        try{
            $data = $request->toArray();
            $command = new ValidateUserCommand(
                $data['email'],
                $data['code'],
                $request->getClientIp(),
                $request->headers->get('User-Agent', 'unknown')
            );
            $response = $userValidate->__invoke($command);
            return $this->successResponse(['token' => $response,], "Usuario validado correctamente");
        }catch (\Exception $exception){
            return $this->errorResponse("Error al validar el usuario: " . $exception->getMessage());
        }
    }
}
