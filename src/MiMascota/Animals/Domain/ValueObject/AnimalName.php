<?php

namespace App\MiMascota\Animals\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class AnimalName extends StringValueObject
{
    public static function generate(string $value) : self
    {
        return new self($value);
    }
}
