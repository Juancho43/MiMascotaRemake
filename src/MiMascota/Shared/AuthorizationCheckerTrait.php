<?php

namespace App\MiMascota\Shared;

use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait AuthorizationCheckerTrait
{
    use ApiResponseTrait;

    public function __construct(private readonly CheckToken $userLogin)
    {

    }
    protected function checkAuthorization(Request $request,): User|JsonResponse
    {

        $user = $this->userLogin->__invoke($request->headers->get('Authorization'));
        if(!$user) {
            return $this->errorResponse("Unauthorized", Response::HTTP_UNAUTHORIZED);
        }
        return $user;
    }
}
