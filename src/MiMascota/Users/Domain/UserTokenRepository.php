<?php

namespace App\MiMascota\Users\Domain;

use App\MiMascota\Users\Domain\ValueObject\UserToken;

interface UserTokenRepository
{

    public function save(UserToken $token): void;

    public function findByTokenAndIP(string $tokenValue, string $ipAddress): ?UserToken;

    public function findByUserAndIP(User $user, string $ipAddress): array;

    public function findByIP(string $ipAddress): array;

    public function deleteByTokenAndIP(string $tokenValue, string $ipAddress): void;

    public function deleteExpiredTokens(): int;

    public function deleteAllByUserAndIP(User $user, string $ipAddress): void;

    public function countActiveTokensByIP(string $ipAddress): int;
}
