<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Infrastructure\ReverseGeocodeClient;

class LocationManager
{
    public function __construct(private ReverseGeocodeClient $geocodeClient, private SaveLocation $saveLocation)
    {

    }

    public function __invoke(string $latitude, string $longitude): Location
    {
        $locationData = $this->geocodeClient->reverseGeocode($latitude, $longitude);
        $location = $this->saveLocation->__invoke(
            $locationData['locality'] ?? '',
            $locationData['countryName'] ?? '',
            $latitude,
            $longitude
        );
        return $location;
    }
}
