<?php

namespace App\MiMascota\Entries\Application\DTO;

use App\MiMascota\Entries\Domain\Entry;

class EntryImagesResponse
{
    public static function generate(Entry $entry) : array
    {
        return [
            'id' => $entry->getId(),
            'images' => $entry->getImages()->toArray()
        ];
    }
}
