<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\UserChangePassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserChangePasswordController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;
    #[Route('/user/password', name: 'user_change_password', methods: ['POST'])]
    public function __invoke(Request $request, UserChangePassword $userChangePassword): JsonResponse
    {
        $this->checkAuthorization($request);
        $data = $request->toArray();
        $userChangePassword->__invoke(
            $data['id'],
            $data['new_password'],
        );
        return $this->successResponse(message: 'User change password');
    }
}
