<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\Command\CreateEntryCommand;
use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Entries\Domain\ValueObject\EntryContent;
use App\MiMascota\Entries\Domain\ValueObject\EntryDate;
use App\MiMascota\Entries\Domain\ValueObject\EntryTitle;
use App\MiMascota\Journals\Application\JournalGetById;
use App\MiMascota\Journals\Application\Query\GetJournalByIdQuery;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use DateTime;
use DateTimeZone;
use Ramsey\Uuid\Nonstandard\Uuid;


final readonly class EntryCreator
{

    public function __construct(
        private EntryRepository $repository,
        private JournalGetById $journalGetById,
    ){}

    public function __invoke(
     CreateEntryCommand $command
    ): Entry
    {
        $journal = $this->journalGetById->__invoke(new GetJournalByIdQuery($command->journalId));
        $entry = Entry::create(
            id: Uuid::uuid4()->toString(),
            title: EntryTitle::generate($command->title),
            content: EntryContent::generate($command->content),
            date: EntryDate::generate($command->date),
            journal: $journal
        );
        $journal->addEntry($entry);
        $this->repository->save($entry);
        return $entry;
    }
}
