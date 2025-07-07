<?php

namespace App\MiMascota\Journals\Infrastructure;

use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
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
}
