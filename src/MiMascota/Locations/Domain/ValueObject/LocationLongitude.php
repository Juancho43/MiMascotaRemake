<?php

namespace App\MiMascota\Locations\Domain\ValueObject;

use phpDocumentor\Reflection\PseudoTypes\StringValue;

class LocationLongitude extends CoordinatesValueObject
{
    public static function create(string $value): self
    {
        return new self($value);
    }
}
