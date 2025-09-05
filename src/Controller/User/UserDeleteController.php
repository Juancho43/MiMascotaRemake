<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserSoftDelete;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDeleteController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/user/delete/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function __invoke(Request $request, UserSoftDelete $softDelete, string $id) : Response
    {
        try{
            $user = $this->checkAuthorization($request);
            if ($user->getId() !== $id) {
                throw new UserPermissionDenied('No tienes permiso para eliminar este usuario');
            }
            $softDelete->__invoke(new GetUserByIdQuery($id));
            return $this->successResponse( "Usuario eliminado correctamente");
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
