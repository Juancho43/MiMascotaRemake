<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Locations\Domain\ValueObject\LocationCity;
use App\MiMascota\Locations\Domain\ValueObject\LocationCountry;
use App\MiMascota\Locations\Domain\ValueObject\LocationLatitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationLongitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationSlug;
use App\MiMascota\Shared\SlugGenerator;
use Ramsey\Uuid\Uuid;


final readonly class SaveLocation
{

    public function __construct(private LocationRepository $repository, private LocationGetByCords $checkLocation)
    {

    }

    public function __invoke(string $city, string $country, string $latitude, string $longitude): Location
    {
        $location = $this->checkLocation->__invoke($latitude, $longitude, $city);
        if ($location instanceof Location) {
            return $location;
        }

        $location = Location::create(
            id: Uuid::uuid4()->toString(),
            city: LocationCity::create($city),
            slug: LocationSlug::create(SlugGenerator::generate($city)),
            country: LocationCountry::create($country),
            latitude: LocationLatitude::create(substr($latitude, 0, 7)),
            longitude: LocationLongitude::create(substr($longitude, 0, 7))
        );

        $this->repository->save($location);

        return $location;
    }
}
