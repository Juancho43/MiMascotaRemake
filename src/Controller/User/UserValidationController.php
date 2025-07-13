<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserValidationController extends AbstractController
{
    #[Route('/user/validate', name: 'user_validate', methods: ['POST'])]
    public function __invoke()
    {

    }
}
