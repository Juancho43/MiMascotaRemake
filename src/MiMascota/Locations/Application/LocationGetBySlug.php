<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Application\Query\GetLocationBySlugQuery;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class LocationGetBySlug
{

    public function __construct(
        private LocationRepository $repository
    )
    {

    }

    public function __invoke(GetLocationBySlugQuery $query): Location
    {
        $location = $this->repository->findBySlug($query->locationSlug);
        if (null === $location) {
            throw new ModelNotFound('Location', 'slug', $query->locationSlug);
        }
        return $location;
    }
}
