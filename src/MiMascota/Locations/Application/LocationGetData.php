<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Application\Query\GetLocationPaginatedDataQuery;
use App\MiMascota\Locations\Domain\LocationRepository;

final readonly class LocationGetData
{
    public function __construct(
        private LocationRepository $repository
    )
    {

    }

    public function __invoke(GetLocationPaginatedDataQuery $query) : array
    {
        return $this->repository->getAll($query->page, $query->limit);
    }
}
