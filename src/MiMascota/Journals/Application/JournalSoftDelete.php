<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Journals\Domain\JournalRepository;

class JournalSoftDelete
{

    public function __construct(
        private readonly JournalRepository $repository,
    ) {
    }
    public function __invoke(string $id): void
    {
        $journal = $this->repository->search($id);

        if ($journal === null) {
            throw new \DomainException("Journal with ID {$id} not found.");
        }

        $journal->getSoftDelete()->markAsDeleted();
        $this->repository->save($journal);
    }
}
