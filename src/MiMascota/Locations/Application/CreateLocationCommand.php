<?php

namespace App\MiMascota\Locations\Application;

class CreateLocationCommand
{
    public function __construct(
        public string $latitude,
        public string $longitude,
        public string $city,
        public string $country,
    )
    {

    }
}
