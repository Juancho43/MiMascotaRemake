<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;


final readonly class SaveLocation
{

    public function __construct(private LocationRepository $repository, private SearchLocation $checkLocation)
    {

    }

    public function __invoke(string $city, string $country, string $latitude, string $longitude): Location
    {
        $location = $this->checkLocation->__invoke($latitude, $longitude, $city);
        if ($location instanceof Location) {
            return $location;
        }

        $location = Location::create(
            id: uniqid(),
            city: $city,
            country: $country,
            latitude: substr($latitude, 0, 7),
            longitude: substr($longitude, 0, 7)
        );

        $this->repository->save($location);

        return $location;
    }
}
