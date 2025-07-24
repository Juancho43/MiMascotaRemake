<?php

namespace App\MiMascota\Entries\Application\DTO;

use App\MiMascota\Entries\Domain\Entry;

class EntryResponse
{

    public static function generate(Entry $entry) : array
    {
        return [
            'id'  =>$entry->getId(),
            'title' => $entry->getTitle(),
            'content' => $entry->getContent(),
            'date' => $entry->getDate()->format('Y-m-d H:i:s'),
            'images' => $entry->getImages()->toArray(),
            'journal_id' => $entry->getJournal()->getId()
        ];
    }

}
