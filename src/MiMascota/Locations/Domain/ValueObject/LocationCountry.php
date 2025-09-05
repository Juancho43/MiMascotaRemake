<?php

namespace App\MiMascota\Locations\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class LocationCountry extends StringValueObject
{

    public static function create(string $value): self
    {
        return new self($value);
    }
}
