<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Journals\Application\Query\GetJournalByIdQuery;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class JournalSoftDelete
{

    public function __construct(
        private JournalGetById $journalGetById,
        private JournalRepository $repository,
    ) {
    }
    public function __invoke(GetJournalByIdQuery $query): void
    {
        $journal = $this->journalGetById->__invoke($query);

        $journal->getSoftDelete()->markAsDeleted();
        $journal->getTimeStamp()->update();
        $this->repository->save($journal);
    }
}
