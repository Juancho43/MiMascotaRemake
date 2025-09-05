<?php

namespace App\MiMascota\Locations\Domain;

interface LocationResolver
{
    public function getLocation(float $latitude, float $longitude) : Location;
}
