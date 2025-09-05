<?php

namespace App\MiMascota\Locations\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class LocationLatitude extends CoordinatesValueObject
{

    public static function create(string $value): self
    {
        return new self($value);
    }



}
