<?php

namespace App\MiMascota\Users\Domain\ValueObject;

class UserToken
{
    private ?string $value;
    private ?\DateTime $createdAt;
    private ?\DateTime $expireAt;

    private function __construct(
    ) {
        $this->value = bin2hex(random_bytes(16));
        $this->createdAt = new \DateTime();
        $this->expireAt = (new \DateTime())->modify('+7 days');
    }

    public static function generate(): self
    {
        return new self();
    }

    public function getExpireAt(): ?\DateTime
    {
        return $this->expireAt;
    }


    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }


    public function getValue(): ?string
    {
        return $this->value;
    }

    public function reset() : void
    {
        $this->value = null;
        $this->createdAt = null;
        $this->expireAt = null;
    }

    public function isExpired() : bool
    {
        return $this->value !== null && $this->expireAt > new \DateTime();
    }

    public function checkExpired(): void
    {
        if ($this->isExpired()) {
            throw new \Exception('Token is expired');
        }
    }
}
