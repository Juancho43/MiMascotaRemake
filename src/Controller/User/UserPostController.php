<?php

namespace App\Controller\User;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\MiMascota\Users\Application\UserCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/user/post',
            controller: self::class . '::post',
            description: 'Crear un nuevo usuario',
            name: 'user_create'
        )
    ]
)]
class UserPostController extends AbstractController
{

    #[Route('/user/post', name: 'user_post', methods:  ['POST'])]
    public function post(Request $request, UserCreator $creator): Response
    {
        $data = $request->toArray();
        $creator->__invoke(
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        return new JsonResponse('User created successfully!', Response::HTTP_CREATED);
    }
}
