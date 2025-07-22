<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Shared\SerializerTrait;
use App\MiMascota\Users\Application\UserGetData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserGetDataController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait,SerializerTrait;

    #[Route('/user', name: 'user_data', methods: ['GET'])]
    public function __invoke(Request $request, UserGetData $userGetData) : Response
    {
        $user = $this->checkAuthorization($request);
        $ip = $request->getClientIp();
        $userAgent = $request->headers->get('User-Agent');
        $data = $userGetData->__invoke($user->findTokenByIpAndUserAgent($ip, $userAgent)->getValue());
        if ($data === null) {
            return $this->errorResponse('User not found');
        }
        return $this->successResponse($this->serialize($data), 'User data retrieved successfully');
    }
}
