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
        return $this->findOneBy(['name' => $name]);
        //Todo :filter by user
    }

    public function update(Animal $animal): void
    {
        // TODO: Implement update() method.
    }

    public function getAnimals(string $userId): array
    {
        return $this->createQueryBuilder('animal')
            ->select('animal.name','journal.id AS journalId' ,'imageFile.path')
            ->join('animal.journal', 'journal')
            ->leftJoin('animal.images', 'images')
            ->leftJoin('images.image', 'imageFile')
            ->where('journal.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function getAnimal(string $journalId): ?Animal
    {
        return $this->createQueryBuilder('animal')
            ->innerJoin('animal.journal', 'journal')
            ->innerJoin('journal.user', 'user')
            ->select('animal', 'journal', 'user')
            ->where('journal.id = :journalId')
            ->setParameter('journalId', $journalId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getWithImages(string $id): ?Animal
    {
        return $this->createQueryBuilder('animal')
            ->leftJoin('animal.images', 'images')
            ->leftJoin('images.image', 'imageFile')
            ->addSelect('images', 'imageFile')
            ->where('animal.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getWithImagesFromJournal(string $id): ?Animal
    {
        return $this->createQueryBuilder('animal')
            ->leftJoin('animal.images', 'images')
            ->leftJoin('images.image', 'imageFile')
            ->addSelect('images', 'imageFile')
            ->innerJoin('animal.journal', 'journal')
            ->where('journal.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
