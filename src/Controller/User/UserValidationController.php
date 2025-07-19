<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
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
            $response = $userValidate->__invoke(
                $data['email'],
                $data['code'],
            );
            return $this->successResponse(['token' => $response,], "Usuario validado correctamente");
        }catch (\Exception $exception){
            return $this->errorResponse("Error al validar el usuario: " . $exception->getMessage());
        }


    }
}
