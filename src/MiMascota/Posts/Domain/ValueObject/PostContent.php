<?php

namespace App\MiMascota\Posts\Domain\ValueObject;

use App\MiMascota\Shared\Domain\InvalidFormat;
use App\MiMascota\Shared\Domain\InvalidLength;
use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class PostContent extends StringValueObject
{
    public static function create(string $value): self
    {
        return new self($value);
    }
}
