<?php

namespace App\MiMascota\Entries\Application\Command;

class SoftDeleteEntryCommand
{
    public function __construct(
        public string $entryId,
    )
    {

    }
}
