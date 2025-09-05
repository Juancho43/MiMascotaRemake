<?php

namespace App\MiMascota\Entries\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class EntryTitle extends StringValueObject
{
    public static function generate(string $value) : self
    {
        return new self($value);
    }
}
