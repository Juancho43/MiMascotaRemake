<?php

namespace App\MiMascota\Locations\Application\DTO;

use App\MiMascota\Locations\Domain\Location;

class LocationResponse
{
    public static function generate(Location $location) : array
    {
        return [
            'id' => $location->getId(),
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
            'city' => $location->getCity(),
            'slug' => $location->getSlug()->getValue(),
            'country' => $location->getCountry(),
            'createdAt' => $location->getTimeStamp()->getCreatedAt()?->format('Y-m-d H:i:s'),
            'updatedAt' => $location->getTimeStamp()->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}



