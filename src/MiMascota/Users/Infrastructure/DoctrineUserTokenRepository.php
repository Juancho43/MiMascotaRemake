<?php

namespace App\MiMascota\Users\Infrastructure;

use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserTokenRepository;
use App\MiMascota\Users\Domain\ValueObject\UserToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserTokenRepository extends ServiceEntityRepository implements UserTokenRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }
    public function save(UserToken $token): void
    {
        // TODO: Implement save() method.
    }

    public function findByTokenAndIP(string $tokenValue, string $ipAddress): ?UserToken
    {
        // TODO: Implement findByTokenAndIP() method.
    }

    public function findByUserAndIP(User $user, string $ipAddress): array
    {
        // TODO: Implement findByUserAndIP() method.
    }

    public function findByIP(string $ipAddress): array
    {
        // TODO: Implement findByIP() method.
    }

    public function deleteByTokenAndIP(string $tokenValue, string $ipAddress): void
    {
        // TODO: Implement deleteByTokenAndIP() method.
    }

    public function deleteExpiredTokens(): int
    {
        // TODO: Implement deleteExpiredTokens() method.
    }

    public function deleteAllByUserAndIP(User $user, string $ipAddress): void
    {
        // TODO: Implement deleteAllByUserAndIP() method.
    }

    public function countActiveTokensByIP(string $ipAddress): int
    {
        // TODO: Implement countActiveTokensByIP() method.
    }
}
