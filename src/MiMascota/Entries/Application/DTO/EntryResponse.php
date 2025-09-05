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
            'date' => $entry->getDate(),
            'images' => $entry->getImages()->toArray(),
            'journal_id' => $entry->getJournal()->getId(),
            'created_at' => $entry->getTimeStamp()->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $entry->getTimeStamp()->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
    }

}
