<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserGetDataController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;

    #[Route('/user', name: 'user_data', methods: ['GET'])]
    public function __invoke(Request $request)
    {
        $user = $this->checkAuthorization($request);
    }
}
