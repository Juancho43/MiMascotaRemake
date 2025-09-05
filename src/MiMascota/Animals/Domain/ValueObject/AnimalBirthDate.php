<?php

namespace App\MiMascota\Animals\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\DateValueObject;
use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class AnimalBirthDate extends DateValueObject
{
    public static function generate(string $value) : self
    {
        return new self($value);
    }
}
