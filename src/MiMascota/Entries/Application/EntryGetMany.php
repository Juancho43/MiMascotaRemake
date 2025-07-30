<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\DTO\EntriesResponse;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Journals\Domain\JournalRepository;

final readonly class EntryGetMany
{
    public function __construct(
        private JournalRepository $repository,
        private EntryRepository $entryRepository
    ) {
    }

    public function __invoke(string $journalId, int $page = 1, int $limit = 3): array
    {
        $entries = $this->repository->getEntries($journalId, $page, $limit);

        return EntriesResponse::generate($entries[0]);
    }

}
