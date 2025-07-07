<?php

namespace App\MiMascota\Users\Infrastructure;

use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function search(string $id): ?User
    {
        return $this->getEntityManager()->find(User::class, $id);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
    public function remove(User $user): void
    {
        // TODO: Implement remove() method.
    }

     public function findByMail(string $email): ?User
     {
         return $this->findOneBy(['email' => $email]);
     }
    public function findByToken(string $token): ?User
    {
         return $this->createQueryBuilder('u')
        ->where('u.token.value = :token')
        ->setParameter('token', $token)
        ->getQuery()
        ->getOneOrNullResult();
    }
}
