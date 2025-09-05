<?php

namespace App\MiMascota\Shared;

use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait AuthorizationCheckerTrait
{
    use ApiResponseTrait;

    public function __construct(private readonly CheckToken $checkToken)
    {

    }
    protected function checkAuthorization(Request $request,):User
    {

        $user = $this->checkToken->__invoke($request->headers->get('Authorization'));
        if(!$user) {
            throw new \Exception('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        return $user;
    }
}
