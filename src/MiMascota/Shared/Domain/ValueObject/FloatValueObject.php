<?php

namespace App\MiMascota\Shared\Domain\ValueObject;

class FloatValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        if (!is_finite($value)) {
            throw new \InvalidArgumentException('Value must be a finite float.');
        }
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
