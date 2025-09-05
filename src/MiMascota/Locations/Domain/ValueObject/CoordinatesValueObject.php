<?php

namespace App\MiMascota\Locations\Domain\ValueObject;

class CoordinatesValueObject
{
    protected const MAX_LENGTH = 8; // Adjusted for latitude precision
    protected const MIN_LENGTH = 1; // Minimum length for latitude
    protected const REGEX = '/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/'; // Regex for valid latitude values
    protected function __construct(protected string $value)
    {

        if (!$this->isValid($value)) {
            throw new \InvalidArgumentException(sprintf('Invalid latitude value: %s', $value));
        }
    }
    public static function create(string $value): self
    {
        return new self($value);
    }

    private function isValid($value): bool
    {
        // Validate the latitude value
        return preg_match(self::REGEX, $value) === 1 &&
            strlen($value) >= self::MIN_LENGTH &&
            strlen($value) <= self::MAX_LENGTH;
    }
    public function getValue(): string
    {
        return $this->value;
    }
}
