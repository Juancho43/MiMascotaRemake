<?php

namespace App\MiMascota\Entries\Application\DTO;

use App\MiMascota\Entries\Domain\Entry;

class EntryCreatedResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $content,
        public readonly \DateTime $date,
        public readonly string $journalId = '',
    )
    {

    }

    public static function fromEntity(Entry $entry) : self
    {
        return new self(
            id: $entry->getId(),
            title: $entry->getTitle(),
            content: $entry->getContent(),
            date: $entry->getDate(),
            journalId: $entry->getJournal()->getId()
        );
    }

}
