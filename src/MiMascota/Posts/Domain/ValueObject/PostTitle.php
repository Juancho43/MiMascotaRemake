<?php

namespace App\MiMascota\Posts\Domain\ValueObject;

use App\MiMascota\Shared\Domain\InvalidFormat;
use App\MiMascota\Shared\Domain\InvalidLength;
use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class PostTitle extends StringValueObject
{

    public const MAX_LENGTH = 50;
    public const MIN_LENGTH = 3;

    protected function __construct(string $value)
    {
        parent::__construct($value);
        if (strlen($value) > self::MAX_LENGTH) {
            throw new InvalidLength(self::class,self::MIN_LENGTH,self::MAX_LENGTH);
        }
    }
     public static function create(string $value): self
    {
        return new self($value);
    }

}
