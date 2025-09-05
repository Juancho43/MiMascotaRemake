<?php

namespace App\MiMascota\Reports\Domain\ValueObject;

class ReportStatus
{

    private const VALID_STATUSES = [
        'Pending',
        'Reviewed',
        'Resolved',
        'Dismissed'
    ];

    private function __construct(private readonly string $value)
    {
        $this->ensureIsValidStatus($value);
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    private function ensureIsValidStatus(string $value): void
    {
        if (!in_array($value, self::VALID_STATUSES, true)) {
            throw new \InvalidArgumentException("Invalid report status: $value");
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function getValidStatuses(): array
    {
        return self::VALID_STATUSES;
    }
}
