<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Shared\SerializerTrait;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Application\DTO\UserResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserGetDataController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait,SerializerTrait;

    #[Route('/user', name: 'user_data', methods: ['GET'])]
    public function __invoke(Request $request, UserGetById $userGetData) : Response
    {
        try{
            $user = $this->checkAuthorization($request);
            $command = new GetUserByIdQuery($user->getId());
            $data = $userGetData->__invoke($command);
            return $this->successResponse(UserResponse::generate($data), 'User data retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
