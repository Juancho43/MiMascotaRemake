<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\Command\UserIsAdminCommand;
use App\MiMascota\Users\Application\Command\ValidateUserCommand;
use App\MiMascota\Users\Application\DTO\UserRolResponse;
use App\MiMascota\Users\Application\UserIsAdminByTokenSession;
use App\MiMascota\Users\Application\UserValidate;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserGetRoleController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/user/role', name: 'user_role', methods: ['GET'])]
    public function __invoke(Request $request, UserIsAdminByTokenSession $userIsAdmin) : JsonResponse
    {
        try{
            $command = new UserIsAdminCommand(
                $request->getClientIp(),
                $request->headers->get('User-Agent', 'unknown'),
                CheckToken::format($request->headers->get('Authorization'))
            );
            return $this->successResponse($userIsAdmin->__invoke($command), "Rol del usuario obtenido correctamente");
        }catch (\Exception $exception){
            return $this->errorResponse("Error al obtener el rol: " . $exception->getMessage(), code: Response::HTTP_OK);
        }
    }
}
