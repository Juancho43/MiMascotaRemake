<?php

namespace App\MiMascota\Entries\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class EntryContent extends StringValueObject
{
    public static function generate(string $value) : self
    {
        return new self($value);
    }
}
