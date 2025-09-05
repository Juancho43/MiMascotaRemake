<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Application\Query\GetLocationByIdQuery;
use App\MiMascota\Locations\Application\Query\GetLocationBySlugQuery;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class LocationGetById
{

    public function __construct(
        private LocationRepository $repository
    )
    {

    }

    public function __invoke(GetLocationByIdQuery $query): Location
    {
        $location = $this->repository->findById($query->locationId);
        if (!$location) {
            throw new ModelNotFound('Location', 'id', $query->locationId);
        }
        return $location;
    }
}
