<?php

namespace App\MiMascota\Shared;

use App\MiMascota\Users\Domain\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\MiMascota\Users\Infrastructure\UserLogin;

trait AuthorizationCheckerTrait
{
    use ApiResponseTrait;

    protected function checkAuthorization(Request $request, UserLogin $login): User|JsonResponse
    {
        $user = $login->__invoke($request->headers->get('Authorization'));
        if(!$user) {
            return $this->errorResponse("Unauthorized", Response::HTTP_UNAUTHORIZED);
        }
        return $user;
    }
}
