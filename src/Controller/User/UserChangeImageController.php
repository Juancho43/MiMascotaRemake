<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserChangeImageController extends AbstractController
{
        #[Route('/user/password', name: 'user_change_password', methods: ['PUT'])]
    public function __invoke()
    {

    }
}
