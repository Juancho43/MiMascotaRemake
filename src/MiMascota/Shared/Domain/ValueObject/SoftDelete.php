<?php

namespace App\MiMascota\Shared\Domain\ValueObject;

class SoftDelete
{
    private ?\DateTime $deletedAt = null;

    public function __construct()
    {
        // Initialize with no deletion time
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function markAsDeleted(): void
    {
        $this->deletedAt = new \DateTime();
    }

    public function restore(): void
    {
        $this->deletedAt = null;
    }
}
