<?php

namespace App\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\User;

class UserToken
{
    private ?string $value;
    private ?\DateTime $createdAt;
    private ?\DateTime $expireAt;
    private ?string $ipAddress;
    private ?string $userAgent;

    private function __construct(
        private string $id,
        private User $user,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ) {
        $this->value = bin2hex(random_bytes(32)); // Incrementé el tamaño por seguridad
        $this->createdAt = new \DateTime();
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->generateExpiredAt();
    }

    public static function generate(
        string $id,
        User $user,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): self {
        return new self($id, $user, $ipAddress, $userAgent);
    }


    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
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

    public function getHashedValue(): ?string
    {
        return $this->value ? hash('sha256', $this->value) : null;
    }

    public function reset(): self
    {
        $this->value = null;
        $this->createdAt = null;
        $this->expireAt = null;
        $this->ipAddress = null;
        $this->userAgent = null;
        return $this;
    }

    public function isValidForIP(string $ipAddress): bool
    {
        return $this->ipAddress === $ipAddress;
    }

    private function isExpired($date = 'now'): bool
    {
        if (!$this->expireAt) {
            throw new \Exception('Token has not been generated');
        }

        return $this->expireAt < (new \DateTime($date));
    }

    public function checkExpired($date = 'now'): string
    {
        if ($this->isExpired($date)) {
            throw new \Exception('Token is expired');
        }
        $this->expireAt->modify('+7 days');
        return $this->getValue();
    }

    public function validateWithIP(string $ipAddress, $date = 'now'): string
    {
        if (!$this->isValidForIP($ipAddress)) {
            throw new \Exception('Token not valid for this IP address');
        }

        return $this->checkExpired($date);
    }

    private function generateExpiredAt($days = '+7 days'): void
    {
        $this->expireAt = (new \DateTime())->modify($days);
    }
}
