<?php

namespace App\MiMascota\Animals\Infrastructure;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Journals\Domain\Journal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 *
 */
class DoctrineAnimalRepository extends ServiceEntityRepository implements AnimalRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function search(string $id): ?Animal
    {
        return $this->getEntityManager()->find(Animal::class, $id);
    }

    public function save(Animal $animal): void
    {
        $this->getEntityManager()->persist($animal);
        $this->getEntityManager()->flush();
    }
    public function remove(Journal $user): void
    {
        // TODO: Implement remove() method.
    }

    public function searchByName(string $name): ?Animal
    {
        // TODO: Implement searchByName() method.
    }

    public function update(Animal $animal): void
    {
        // TODO: Implement update() method.
    }
}
