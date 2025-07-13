<?php

namespace App\MiMascota\Shared\Domain\ValueObject;

class TimeStamp
{

    private \DateTime $createdAt;
    private ?\DateTime $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function update(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
