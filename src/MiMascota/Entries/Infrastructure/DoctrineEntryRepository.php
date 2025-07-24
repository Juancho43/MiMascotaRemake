<?php

namespace App\MiMascota\Entries\Infrastructure;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entry>
 *
 */
class DoctrineEntryRepository extends ServiceEntityRepository implements EntryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entry::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function search(string $id): ?Entry
    {
        return $this->createQueryBuilder('entry')
            ->leftJoin('entry.images', 'images')
            ->addSelect('images')
            ->where('entry.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Entry $entry): void
    {
        $this->getEntityManager()->persist($entry);
        $this->getEntityManager()->flush();
    }
    public function remove(Entry $entry): void
    {
        $this->getEntityManager()->remove($entry);
        $this->getEntityManager()->flush();
    }




   public function getPhotos(string $id): array
   {
       return $this->getEntityManager()
           ->createQueryBuilder()
           ->select('p')
           ->from('App\MiMascota\Images\Domain\Image', 'p')
           ->where('p.imageableId = :entry')
           ->setParameter('entry', $id)
           ->getQuery()
           ->getResult();
   }
}
