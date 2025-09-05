<?php

namespace App\MiMascota\Shared\Domain\ValueObject;

use App\MiMascota\Shared\Domain\InvalidLength;

class SlugValueObject
{
    public const MAX_LENGTH = 255;
    public const MIN_LENGTH = 3;
    protected const REGEX = '/^[a-z0-9]+(?:-[a-z0-9]+)*$/';
    protected function __construct(protected string $value)
    {

        if (strlen($value) > self::MAX_LENGTH) {
            throw new InvalidLength(self::class,self::MIN_LENGTH,self::MAX_LENGTH);
        }
    }
    public static function create(string $value): self
    {
        return new self($value);
    }
    public function getValue(): string
    {
        return $this->value;
    }
}
