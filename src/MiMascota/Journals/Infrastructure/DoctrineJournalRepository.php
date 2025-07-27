<?php

namespace App\MiMascota\Journals\Infrastructure;


use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Journal>
 *
 */
class DoctrineJournalRepository extends ServiceEntityRepository implements JournalRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Journal::class);
    }

    public function search(string $id): ?Journal
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function getOneById(string $id): ?array
    {
        return $this->createQueryBuilder('journal')
            ->select('journal.id AS id', 'animal.name AS animalName', 'image.id AS imageId', 'imageFile.path AS imagePath')
            ->innerJoin('journal.animal', 'animal')
            ->leftJoin('animal.images', 'image')
            ->leftJoin('image.image', 'imageFile')
            ->where('journal.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Journal $journal): void
    {
        $this->getEntityManager()->persist($journal);
        $this->getEntityManager()->flush();
    }

    public function remove(Journal $journal): void
    {
        $this->getEntityManager()->remove($journal);
        $this->getEntityManager()->flush();
    }



    public function getEntries(string $journalId, int $page = 1, int $limit = 3): array
    {
        $offset = ($page - 1) * $limit;
        return $this->createQueryBuilder('journal')
            ->innerJoin('journal.entries', 'entry')
            ->select('entry.content', 'entry.date', 'entry.title', 'entry.id')
            ->where('journal.id = :journalId')
            ->setParameter('journalId', $journalId)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('entry.date', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }


   public function getAnimal(string $journalId): ?array
    {
        return $this->createQueryBuilder('journal')
            ->innerJoin('journal.animal', 'animal')
            ->select('journal.id AS journalId', 'animal')
            ->where('journal.id = :journalId')
            ->setParameter('journalId', $journalId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
