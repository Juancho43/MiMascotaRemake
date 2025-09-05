<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Journals\Application\Query\GetJournalByIdQuery;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

class JournalGetById
{
    public function __construct(
        private JournalRepository $repository,
    ) {
    }
    public function __invoke(GetJournalByIdQuery $query): Journal
    {
        $journal = $this->repository->search($query->journalId);

        if ($journal === null) {
            throw new ModelNotFound("journal");

        }
        return $journal;
    }
}
