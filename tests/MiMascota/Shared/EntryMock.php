<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\ValueObject\EntryContent;
use App\MiMascota\Entries\Domain\ValueObject\EntryDate;
use App\MiMascota\Entries\Domain\ValueObject\EntryTitle;
use App\MiMascota\Journals\Domain\Journal;

class EntryMock
{
    public static function generate($id,
                                    Journal $journal,
                                    $date,
                                    $title = 'Test Entry',
                                    $content = 'mock content',
    ) : Entry
    {
        return Entry::create(
            $id,
            EntryTitle::generate($title),
            EntryContent::generate($content),
            EntryDate::generate($date),
            $journal,
        );
    }
}
