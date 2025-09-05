<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\DTO\EntryResponseCollection;
use App\MiMascota\Entries\Application\Query\EntryGetByJournalSlugPaginationQuery;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Journals\Domain\JournalRepository;

final readonly class EntryGetManyPagination
{
    public function __construct(
        private JournalRepository $repository,
    ) {
    }

    public function __invoke(EntryGetByJournalSlugPaginationQuery $query): array
    {
        return $this->repository->getEntries($query->journalSlug, $query->page, $query->limit);
    }

}
