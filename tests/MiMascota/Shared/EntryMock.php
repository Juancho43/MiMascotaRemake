<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Journals\Domain\Journal;

class EntryMock
{
    public static function EntryMock($id,$title,$content,$date, Journal $journal) : Entry
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
