<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserGetDataController extends AbstractController
{
    #[Route('/user', name: 'user_data', methods: ['GET'])]
    public function __invoke()
    {

    }
}
