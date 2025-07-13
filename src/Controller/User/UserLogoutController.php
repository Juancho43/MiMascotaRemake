<?php
namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\UserLogout;
use App\MiMascota\Users\Infrastructure\IsUserLoggedIn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserLogoutController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;
    #[Route('/user/logout', name: 'user_logout', methods:  ['POST'])]
    public function login(Request $request, IsUserLoggedIn $login, UserLogout $userlogout) : Response
    {
        $user = $this->checkAuthorization($request, $login);
        $userlogout->__invoke(
            $user->getToken()
        );
        return $this->successResponse(message:  "Usuario desconectado correctamente");

    }
}
