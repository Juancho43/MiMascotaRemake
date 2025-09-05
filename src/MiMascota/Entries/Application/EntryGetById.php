<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\Query\EntryGetByIdQuery;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class EntryGetById
{
    public function __construct(
        private EntryRepository $repository
    )
    {

    }
    public function __invoke(EntryGetByIdQuery $query):Entry
    {

        $entry = $this->repository->search($query->entryId);
        if ($entry === null) {
            throw new ModelNotFound('Entry', 'id', $query->entryId);
        }
        return $entry;
    }
}
