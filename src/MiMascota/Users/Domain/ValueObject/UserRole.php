<?php

namespace App\MiMascota\Users\Domain\ValueObject;

class UserRole
{
    public const ADMIN = 'admin';
    public const USER = 'user';
    public const GUEST = 'guest';
    public const MODERATOR = 'moderator';

    public const ROLES = [
        self::ADMIN,
        self::USER,
        self::GUEST,
        self::MODERATOR,
    ];
    private function __construct(
        private readonly string $role,

    )
    {
        if (!in_array($role, self::ROLES)) {
            throw new \InvalidArgumentException("Invalid role: $role");
        }
    }
    public static function generate(string $role): self
    {
        return new self($role);
    }
    public function getRole(): string
    {
        return $this->role;
    }
}
