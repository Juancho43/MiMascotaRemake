<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
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
        private JournalRepository $journalRepository,
    ){

    }

    public function __invoke(string $journalId, string $title, string $content, string $date): Entry
    {
        $journal = $this->journalRepository->search($journalId);
        if (!$journal instanceof Journal) {
            throw new ModelNotFound('Journal' ,'id',$journalId);
        }
        $entry = Entry::create(
            id: Uuid::uuid4()->toString(),
            title: $title,
            content: $content,
            date: new DateTime($date,new DateTimeZone(getenv('TIMEZONE'))),
            journal: $journal
        );
        $journal->addEntry($entry);
        $this->repository->save($entry);
        return $entry;
    }

}
