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

    public function getOneBySlug(string $slug): ?Journal
    {
        return $this->createQueryBuilder('journal')
            ->select(
                'journal',
                'animal',
                'user',

            )
            ->innerJoin('journal.animal', 'animal')
            ->leftJoin('journal.user', 'user')
            ->leftJoin('animal.images', 'image')
            ->leftJoin('journal.entries', 'entry')
            ->where('journal.slug.value = :slug')
            ->setParameter('slug', $slug)
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



    public function getEntries(string $journalSlug, int $page = 1, int $limit = 3): array
    {
        $offset = ($page - 1) * $limit;
        return $this->createQueryBuilder('journal')
            ->innerJoin('journal.entries', 'entry')
            ->select( 'entry','journal')
            ->where('journal.slug.value = :journalSlug')
            ->andWhere('entry.softDelete.deletedAt IS NULL')
            ->setParameter('journalSlug', $journalSlug)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('entry.date.value', 'DESC')
            ->getQuery()
            ->getResult();
    }


   public function getAnimal(string $journalSlug): ?array
    {
        return $this->createQueryBuilder('journal')
            ->innerJoin('journal.animal', 'animal')
            ->select('journal.id AS journal_id', 'animal')
            ->where('journal.id = :journalId')
            ->setParameter('journalId', $journalSlug)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
