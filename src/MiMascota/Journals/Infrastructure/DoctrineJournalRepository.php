<?php

namespace App\MiMascota\Journals\Infrastructure;

use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;

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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function search(string $id): ?Journal
    {
        return $this->getEntityManager()->find(Journal::class, $id);
    }

    public function save(Journal $journal): void
    {
        $this->getEntityManager()->persist($journal);
        $this->getEntityManager()->flush();
    }
    public function remove(Journal $user): void
    {
        // TODO: Implement remove() method.
    }


    public function update(Journal $journal): void
    {
        // TODO: Implement update() method.
    }

  public function getEntries(string $journalId, int $page = 1, int $limit = 3): Collection
{
    $offset = ($page - 1) * $limit;
    $entries = $this->createQueryBuilder('journal')
        ->innerJoin('journal.entries', 'entry')
        ->select('entry.content','entry.date','entry.title', 'entry.id')  // Properly alias the entry
        ->where('journal.id = :journalId')
        ->setParameter('journalId', $journalId)
        ->setFirstResult($offset)
        ->setMaxResults($limit)
        ->orderBy('entry.date', 'DESC')
        ->getQuery()
        ->getResult();

    return new ArrayCollection($entries);
}
}
