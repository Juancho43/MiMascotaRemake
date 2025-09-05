<?php

namespace App\MiMascota\Journals\Application\DTO;

use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Journals\Domain\Journal;

final readonly class JournalResponse
{
    public static function generate(Journal $journal) : array
    {
        return [
            'id' => $journal->getId(),
            'journal_slug' => $journal->getSlug()->getValue(),
            'user_id' => $journal->getUser()->getId(),
            'animal' => AnimalResponse::generate($journal->getAnimal()),
            'entryCount' => $journal->getEntryCount(),
            'created_at' => $journal->getTimeStamp()->getCreatedAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $journal->getTimeStamp()->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
