<?php

namespace App\Controller\Animals;

use App\MiMascota\Animals\Application\AnimalGetImages;
use App\MiMascota\Animals\Application\DTO\AnimalImagesResponse;
use App\MiMascota\Animals\Application\Query\GetAnimalByJournalSlugQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalGetImagesController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/animal/images/{slug}', name: 'animal_get_images', methods: ['GET'])]
    public function __invoke(string $slug, AnimalGetImages $getImages): Response
    {
        try {
            return $this->successResponse(
                AnimalImagesResponse::generate($getImages->__invoke(new GetAnimalByJournalSlugQuery($slug))),
                'Animal images retrieved successfully'
            );
        } catch (\DomainException $exception) {
            return $this->errorResponse($exception->getMessage(),code: Response::HTTP_OK);
        }
    }

}
