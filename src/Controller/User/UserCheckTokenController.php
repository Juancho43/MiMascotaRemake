<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\Command\UserIsAdminCommand;
use App\MiMascota\Users\Application\Command\ValidateUserCommand;
use App\MiMascota\Users\Application\DTO\UserRolResponse;
use App\MiMascota\Users\Application\UserIsAdminByTokenSession;
use App\MiMascota\Users\Application\UserTokenIsValid;
use App\MiMascota\Users\Application\UserValidate;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCheckTokenController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/user/token', name: 'user_token', methods: ['GET'])]
    public function __invoke(Request $request, UserTokenIsValid $userTokenIsValid) : JsonResponse
    {
        try{
            $command = new UserIsAdminCommand(
                $request->getClientIp(),
                $request->headers->get('User-Agent', 'unknown'),
                CheckToken::format($request->headers->get('Authorization'))
            );
            return $this->successResponse($userTokenIsValid->__invoke($command), "Token del usuario validado correctamente");
        }catch (\Exception $exception){
            return $this->errorResponse("Error al validar el token: " . $exception->getMessage(), code: Response::HTTP_OK);
        }
    }
}
