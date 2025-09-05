<?php

namespace App\MiMascota\Animals\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\FloatValueObject;
use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class AnimalWeight extends FloatValueObject
{
    public static function generate(float $value) : self
    {
        return new self($value);
    }
}
