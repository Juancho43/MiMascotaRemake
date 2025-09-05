<?php

namespace App\Controller\Location;

use App\MiMascota\Locations\Application\DTO\LocationResponse;
use App\MiMascota\Locations\Application\LocationGetById;
use App\MiMascota\Locations\Application\LocationGetBySlug;
use App\MiMascota\Locations\Application\Query\GetLocationBySlugQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LocationGetDataController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/locations/{slug}', name: 'location_get', methods: ['GET'])]
    public function __invoke(string $slug,LocationGetBySlug $get) : Response
    {
        try {
            return $this->successResponse(LocationResponse::generate($get->__invoke(new GetLocationBySlugQuery($slug))), 'Location retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
