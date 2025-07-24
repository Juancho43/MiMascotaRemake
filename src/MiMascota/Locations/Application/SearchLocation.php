<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;

final readonly class SearchLocation
{

    public function __construct(private LocationRepository $repository)
    {

    }
    public function __invoke($latitude, $longitude, $city): ?Location
    {
        return $this->repository->findByCords($latitude, $longitude,$city);
    }
}
