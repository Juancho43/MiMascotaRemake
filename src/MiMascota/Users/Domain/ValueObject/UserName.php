<?php

namespace App\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Shared\Domain\InvalidFormat;
use App\MiMascota\Shared\Domain\InvalidLength;

class UserName
{

    private const MAX_LENGTH = 50;
    private const MIN_LENGTH = 3;
    private const REGEX = '/^[a-zA-Z\s]+$/';

    private function __construct(private string $value)
    {
        $this->setValue($value);
    }
    public static function create(string $value): self
    {
        return new self($value);
    }

    private function setValue(string $value): void
    {
        if (strlen($value) < self::MIN_LENGTH || strlen($value) > self::MAX_LENGTH) {
            throw new InvalidLength("User name", self::MIN_LENGTH, self::MAX_LENGTH);
        }
        if (!preg_match(self::REGEX, $value)) {
            throw new InvalidFormat("User name", ' can only contain letters and spaces.');
        }
        $this->value = $value;
    }
    public function getValue(): string
    {
        return $this->value;
    }

}

