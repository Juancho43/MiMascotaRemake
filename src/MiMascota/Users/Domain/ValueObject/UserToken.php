<?php

namespace App\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\User;

class UserToken
{

    private ?string $value;
    private ?\DateTime $createdAt;
    private ?\DateTime $expireAt;

    private function __construct(
        private string $id,
        private User $user
    ) {
        $this->value = bin2hex(random_bytes(16));
        $this->createdAt = new \DateTime();
        $this->genereExpiredAt();
    }

    public static function generate(string $id, User $user): self
    {
        return new self($id, $user);
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

    public function reset() : self
    {
        $this->value = null;
        $this->createdAt = null;
        $this->expireAt = null;
        return $this;
    }

    private function isExpired($date = 'now') : bool
    {
        if (!$this->expireAt) {
            throw new \Exception('Token has not been generated');
        }
        if ($this->expireAt < (new \DateTime($date))) {
            return true;
        }
        $this->expireAt->modify('+7 day');
        return false;
    }





    public function checkExpired($date = 'now'): bool
    {
        if ($this->isExpired($date)) {
            throw new \Exception('Token is expired');
        }
        return false;
    }
    private function genereExpiredAt($days = '+7 days'): void
    {
        $this->expireAt = (new \DateTime())->modify($days);
    }
}
