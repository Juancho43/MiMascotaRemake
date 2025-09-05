<?php

namespace App\MiMascota\Locations\Application\DTO;

class LocationResponseCollection
{
    public static function generate(array $locations) : array
    {
        $response = [];
        foreach ($locations as $location) {
            $response[] = LocationResponse::generate($location);
        }
        return $response;
    }

}
