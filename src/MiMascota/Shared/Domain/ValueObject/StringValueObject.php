<?php

namespace App\MiMascota\Shared\Domain\ValueObject;

use App\MiMascota\Shared\Domain\InvalidFormat;
use App\MiMascota\Shared\Domain\InvalidLength;

class StringValueObject
{


    protected const MAX_LENGTH = 255;
    protected const MIN_LENGTH = 4;
   protected const REGEX = '/^[a-zA-Z\s0-9.!¡¿?]+$/u';

    protected function __construct(protected string $value)
    {
        $this->setValue($value);
    }


    private function setValue(string $value): void
    {
        if (strlen($value) < self::MIN_LENGTH || strlen($value) > self::MAX_LENGTH) {
            throw new InvalidLength(self::class, self::MIN_LENGTH, self::MAX_LENGTH);
        }
        if (!preg_match(self::REGEX, $value)) {
            throw new InvalidFormat(self::class, self::REGEX);
        }
        $this->value = $value;
    }
    public function getValue(): string
    {
        return $this->value;
    }
}
