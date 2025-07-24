<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Journals\Domain\Journal;

class EntryMock
{
    public static function generate($id,
                                    $date,
                                    Journal $journal,
                                    $title = 'Test Entry',
                                    $content = 'mock content',
    ) : Entry
    {
        return Entry::create(
            $id,
            $title,
            $content,
            $date,
            $journal,
        );
    }
}
