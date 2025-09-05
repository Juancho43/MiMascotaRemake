<?php

namespace App\MiMascota\Forums\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class ForumName extends StringValueObject
{
     public static function create(string $value): self
    {
        return new self($value);
    }
}
