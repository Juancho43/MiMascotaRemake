<?php
namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Users\Application\UserLogin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserLoginController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/user/login', name: 'user_login', methods:  ['POST'])]
    public function login(Request $request, UserLogin $userLogin) : Response
    {

        $data = $request->toArray();
        $token = $userLogin->__invoke(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );
        return $this->successResponse(
            [
            'token' => $token,
            ], "Usuario autenticado correctamente");

    }
}
