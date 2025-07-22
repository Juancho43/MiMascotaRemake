<?php

namespace App\MiMascota\Users\Domain\ValueObject;

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
            throw new \InvalidArgumentException("User name must be between " . self::MIN_LENGTH . " and " . self::MAX_LENGTH . " characters.");
        }
        if (!preg_match(self::REGEX, $value)) {
            throw new \InvalidArgumentException("User name can only contain letters and spaces.");
        }
        $this->value = $value;
    }
    public function getValue(): string
    {
        return $this->value;
    }
    public function rename(string $newName): string
    {
        $this->setValue($newName);
        return $this->value;
    }
}

