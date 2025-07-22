<?php
namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\UserLogout;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserLogoutController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;

    /**
     * @throws \Exception
     */
    #[Route('/user/logout', name: 'user_logout', methods:  ['POST'])]
    public function login(Request $request, UserLogout $logout) : Response
    {
        try {
            $ip = $request->getClientIp();
            $userAgent = $request->headers->get('User-Agent', 'unknown');
            $user = $this->checkAuthorization($request);
            $logout->__invoke(
                $user->findTokenByIpAndUserAgent($ip, $userAgent)->getValue(),
                $ip,
                $userAgent
            );
            return $this->successResponse( message: "Usuario desconectado correctamente");
        }catch (\Exception $exception){
            return $this->errorResponse($exception);
        }




    }
}
