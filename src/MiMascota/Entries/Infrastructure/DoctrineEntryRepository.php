<?php

namespace App\MiMascota\Entries\Infrastructure;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
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

   public function getMany(string $journalId, int $page = 1, int $limit = 10):array
   {
       $offset = ($page - 1) * $limit;

       return $this->createQueryBuilder('e')
           ->select('e', 'i', 'j')
              ->leftJoin('e.images', 'i')
           ->join('e.journal', 'j')
           ->where('j.id = :journalId')
           ->setParameter('journalId', $journalId)
           ->setFirstResult($offset)

           ->setMaxResults($limit)
           ->getQuery()
           ->getArrayResult();
   }

    public function getCount(string $journalId): int
    {
       return (int) $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->join('e.journal', 'j')
            ->where('j.id = :journalId')
            ->setParameter('journalId', $journalId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
