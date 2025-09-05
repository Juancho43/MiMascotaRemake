<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\Command\SoftDeleteEntryCommand;
use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Application\Query\EntryGetByIdQuery;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class EntrySoftDelete
{
    public function __construct(
        private EntryRepository $entryRepository,
        private EntryGetById $entryGetById,
    )
    {

    }

    public function __invoke(SoftDeleteEntryCommand $command) : Entry
    {
        $entry = $this->entryGetById->__invoke(new EntryGetByIdQuery($command->entryId));
        $entry->getSoftDelete()->markAsDeleted();
        $entry->getTimeStamp()->update();
        $this->entryRepository->save($entry);
        return $entry;
    }

}
