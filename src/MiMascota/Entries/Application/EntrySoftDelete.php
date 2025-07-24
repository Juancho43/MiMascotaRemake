<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class EntrySoftDelete
{
    public function __construct(private EntryRepository $entryRepository)
    {

    }

    public function __invoke(string $entryId) : array
    {
        $entry = $this->entryRepository->search($entryId);
        if (!$entry instanceof Entry) {
            throw new ModelNotFound('entry');
        }
        $entry->getSoftDelete()->markAsDeleted();
        $this->entryRepository->save($entry);
        return EntryResponse::generate($entry);
    }

}
