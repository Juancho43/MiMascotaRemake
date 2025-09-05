<?php

namespace App\MiMascota\Animals\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class AnimalGender extends StringValueObject
{
    private const values = [
        'male',
        'female',
        'unknown',
    ];

    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->ensureIsValidValue($value);
        $this->value = $value;
    }

    private function ensureIsValidValue(string $value): void
    {
        if (!in_array($value, self::values)) {
            throw new \InvalidArgumentException();
        }
    }
    public static function generate(string $value) : self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
    public static function getValues(): array
    {
        return self::values;
    }

}
