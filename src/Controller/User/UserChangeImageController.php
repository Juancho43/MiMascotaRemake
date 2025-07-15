<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserChangeImageController extends AbstractController
{
    #[Route('/user/image/change', name: 'user_change_image', methods: ['POST'])]
    public function __invoke()
    {

    }
}
