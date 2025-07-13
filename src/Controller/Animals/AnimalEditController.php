<?php

namespace App\Controller\Animals;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnimalEditController extends AbstractController
{
    #[Route('/animal/edit', name: 'animal_edit', methods: ['PUT'])]
    public function __invoke()
    {

    }
}
