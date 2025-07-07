<?php
namespace App\Controller\User;

use App\MiMascota\Users\Application\UserLogin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserLoginController extends AbstractController
{
    #[Route('/user/login', name: 'user_login', methods:  ['POST'])]
    public function login(Request $request, UserLogin $userLogin) : Response
    {

        $data = $request->toArray();
        $token = $userLogin->__invoke(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );
        return new JsonResponse([
            'token' => $token,
        ], $token ? Response::HTTP_OK : Response::HTTP_UNAUTHORIZED);

    }
}
