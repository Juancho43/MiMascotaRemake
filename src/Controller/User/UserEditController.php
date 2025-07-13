<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserEditController extends AbstractController
{
    #[Route('/user/edit', name: 'user_edit', methods: ['PUT'])]
    public function __invoke()
    {

    }
}
