<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserDeleteController extends AbstractController
{
    #[Route('/user/delete', name: 'user_delete', methods: ['DELETE'])]
    public function __invoke()
    {
        // Logic for deleting a user would go here
        // For example, you might retrieve the user from the database and delete them
        // return $this->redirectToRoute('user_list'); // Redirect to a list of users after deletion
    }
}
