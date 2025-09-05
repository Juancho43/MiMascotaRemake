<?php

namespace App\MiMascota\Entries\Application\DTO;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Journals\Domain\Journal;
use Doctrine\Common\Collections\Collection;

class EntryResponseCollection
{
    public static function generate(Journal $journal): array
    {
        $entries = [];
        foreach ($journal->getEntries()->toArray() as $entry) {
            $entries[] = EntryResponse::generate($entry);
        }
        return $entries;
    }
}
