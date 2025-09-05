<?php

namespace App\MiMascota\Entries\Application\Query;

class EntryGetByJournalSlugPaginationQuery
{
    public function __construct(
        public string $journalSlug,
        public int    $page = 1,
        public int    $limit = 3
    )
    {

    }
}
