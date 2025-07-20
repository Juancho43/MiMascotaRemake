<?php

namespace App\MiMascota\Users\Domain\ValueObject;

class UserTelephone
{
    private const MAX_LENGTH = 25;
    private const MIN_LENGTH = 6;
    private const REGEX = '/^\+?[0-9\s]+$/';

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
            throw new \InvalidArgumentException("User telephone must be between " . self::MIN_LENGTH . " and " . self::MAX_LENGTH . " characters.");
        }
        if (!preg_match(self::REGEX, $value)) {
            throw new \InvalidArgumentException("User telephone can only contain numbers and spaces.");
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
