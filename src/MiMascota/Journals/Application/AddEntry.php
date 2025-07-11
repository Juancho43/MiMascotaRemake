<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use Ramsey\Uuid\Nonstandard\Uuid;

class AddEntry
{
    public function __construct(
        private EntryRepository $repository,
        private JournalRepository $journalRepository,
        private string $timezone,
    ){

    }

    public function __invoke(string $journalId, string $title, string $content, string $date): Entry
    {
        $journal = $this->journalRepository->search($journalId);
        if (!$journal instanceof Journal) {
            throw new \InvalidArgumentException('Journal not found');
        }
        $entry = Entry::create(
            id: Uuid::uuid4()->toString(),
            title: $title,
            content: $content,
            date: new \DateTime($date,new \DateTimeZone($this->timezone)),
            journal: $journal
        );
        $journal->addEntry($entry);
        $this->repository->save($entry);
        return $entry;
    }

}
