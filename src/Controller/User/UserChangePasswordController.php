<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\Command\ChangeUserPasswordCommand;
use App\MiMascota\Users\Application\UserChangePassword;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserChangePasswordController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;
    #[Route('/user/password/{id}', name: 'user_change_password', methods: ['POST'])]
    public function __invoke(Request $request, UserChangePassword $userChangePassword, string $id): JsonResponse
    {
        try {
            $user = $this->checkAuthorization($request);
            if ($user->getId() !== $id) {
                throw new UserPermissionDenied('No tienes permiso para cambiar la contraseña de este usuario');
            }
            $data = $request->toArray();
            $command = new ChangeUserPasswordCommand(
                $data['email'],
                $data['new_password'],
            );
            $userChangePassword->__invoke($command);
            return $this->successResponse(message: 'User change password');
        }catch (\Exception $exception){
            return $this->errorResponse(
                message: $exception->getMessage(),
            );
        }
    }
}
