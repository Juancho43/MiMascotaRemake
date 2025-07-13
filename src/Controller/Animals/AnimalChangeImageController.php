<?php

namespace App\Controller\Animals;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnimalChangeImageController extends AbstractController
{
    #[Route('/animal/change/image/', name: 'animal_change_image', methods: ['POST'])]
    public function __invoke()
    {

    }
}
