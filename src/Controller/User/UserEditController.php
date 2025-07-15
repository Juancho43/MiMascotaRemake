<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserEditController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;

    #[Route('/user/edit', name: 'user_edit', methods: ['PUT'])]
    public function __invoke(Request $request)
    {
        $user = $this->checkAuthorization($request);
    }
}
