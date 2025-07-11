<?php

namespace App\Controller\User;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Users\Application\UserCreator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRegisterController
{
    use ApiResponseTrait;
    #[Route('/user/register', name: 'user_register', methods:  ['POST'])]
    public function post(Request $request, UserCreator $creator): Response
    {
        $data = $request->toArray();
        $user = $creator->__invoke(
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        return $this->successResponse($user, "Usuario creado correctamente", Response::HTTP_CREATED);
    }
}
