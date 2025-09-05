<?php

namespace App\Controller\Location;

use App\MiMascota\Locations\Application\Command\LocationSearchCommand;
use App\MiMascota\Locations\Application\DTO\LocationResponseCollection;
use App\MiMascota\Locations\Application\LocationGetData;
use App\MiMascota\Locations\Application\LocationSearch;
use App\MiMascota\Locations\Application\Query\GetLocationPaginatedDataQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LocationSearchController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/locations/search/{search}', name: 'location_search', methods: ['GET'])]
    public function __invoke(LocationSearch $getData, string $search) : Response
    {
        try {
            $data = $getData->__invoke(new LocationSearchCommand($search));
            return $this->successResponse(LocationResponseCollection::generate($data), 'Locations retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
