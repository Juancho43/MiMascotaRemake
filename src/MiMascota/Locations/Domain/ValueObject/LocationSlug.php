<?php

namespace App\MiMascota\Locations\Domain\ValueObject;

use App\MiMascota\Shared\Domain\InvalidFormat;
use App\MiMascota\Shared\Domain\InvalidLength;
use App\MiMascota\Shared\Domain\ValueObject\SlugValueObject;
use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class LocationSlug extends SlugValueObject
{

    public static function create(string $value): self
    {
        $timestamp = substr((string) time(), 0, 5);
        $slugWithTimestamp = $value . '-' . $timestamp;
        return new self($slugWithTimestamp);
    }
}
