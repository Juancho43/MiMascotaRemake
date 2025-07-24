<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class JournalSoftDelete
{

    public function __construct(
        private JournalRepository $repository,
    ) {
    }
    public function __invoke(string $id): void
    {
        $journal = $this->repository->search($id);

        if ($journal === null) {
            throw new ModelNotFound("journal");
        }

        $journal->getSoftDelete()->markAsDeleted();
        $this->repository->save($journal);
    }
}
