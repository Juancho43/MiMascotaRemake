<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class EntryGetOne
{
    public function __construct(
        private EntryRepository $entryRepository,
    )
    {

    }

    public function __invoke(string $id): array
    {
        $entry = $this->entryRepository->search($id);
        if ($entry === null) {
            throw new ModelNotFound('Entry', 'id', $id);
        }

        return EntryResponse::generate($entry);

    }
}
