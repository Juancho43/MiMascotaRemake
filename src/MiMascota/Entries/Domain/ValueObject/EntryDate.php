<?php

namespace App\MiMascota\Entries\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\DateValueObject;

class EntryDate extends DateValueObject
{
    public static function generate(string $date): self
    {
        return new self($date);
    }
}
