<?php

namespace App\MiMascota\ContactRequests\Domain;

class ContactRequestStatus
{
    private const VALID_STATUSES = ['Pending', 'Accepted', 'Rejected'];

    private function __construct(private readonly string $status)
    {
        if (!in_array($status, self::VALID_STATUSES)) {
            throw new \InvalidArgumentException("Invalid contact request status: $status");
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public static function create(string $value) : self
    {
        return new self($value);
    }
    public static function getValidStatuses(): array
    {
        return self::VALID_STATUSES;
    }
}
