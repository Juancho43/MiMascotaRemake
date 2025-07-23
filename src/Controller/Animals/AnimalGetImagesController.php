<?php

namespace App\Controller\Animals;

use App\MiMascota\Animals\Application\AnimalGetImages;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalGetImagesController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/animal/images/{id}', name: 'animal_get_images', methods: ['GET'])]
    public function __invoke(string $id, AnimalGetImages $getImages): Response
    {
        try {
            return $this->successResponse($getImages->__invoke($id), 'Animal images retrieved successfully');
        } catch (\DomainException $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

}
