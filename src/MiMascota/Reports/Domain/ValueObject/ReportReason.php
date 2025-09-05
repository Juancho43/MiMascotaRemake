<?php

namespace App\MiMascota\Reports\Domain\ValueObject;

class ReportReason{
    private const VALID_REASONS = [
        'Spam',
        'Inappropriate Content',
        'Harassment',
        'False Information',
        'Other'
    ];
    private function __construct(private readonly string $value)
    {
        $this->ensureIsValidReason($value);
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    private function ensureIsValidReason(string $value): void
    {
             if (!in_array($value, self::VALID_REASONS, true)) {
            throw new \InvalidArgumentException("Invalid report reason: $value");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function getValidReasons() : array
    {
        return self::VALID_REASONS;
    }

}
