<?php

namespace App\MiMascota\Entries\Application\Query;

class EntryGetByIdQuery
{
    public function __construct(
        public string $entryId
    )
    {

    }
}
