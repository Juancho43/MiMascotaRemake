<?php

namespace App\Controller\Location;

use App\MiMascota\Locations\Application\DTO\LocationResponseCollection;
use App\MiMascota\Locations\Application\LocationGetData;
use App\MiMascota\Locations\Application\Query\GetLocationPaginatedDataQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LocationGetAllController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/locations/{page}/{limit}', name: 'location_get_all', requirements: ['page' => '\d+', 'limit' => '\d+'], methods: ['GET'])]
    public function __invoke(LocationGetData $getData, int $page = 1, int $limit=100) : Response
    {
        try {

            return $this->successResponse(LocationResponseCollection::generate($getData->__invoke(new GetLocationPaginatedDataQuery($page, $limit))), 'Locations retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
