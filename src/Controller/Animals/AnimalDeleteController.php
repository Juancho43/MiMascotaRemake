<?php

namespace App\Controller\Animals;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnimalDeleteController extends AbstractController
{
    #[Route('/animal/delete', name: 'animal_delete', methods: ['DELETE'])]
    public function __invoke()
    {

    }
}
