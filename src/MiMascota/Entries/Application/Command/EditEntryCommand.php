<?php

namespace App\MiMascota\Entries\Application\Command;

class EditEntryCommand
{
    public function __construct(
        public string $entryId,
        public string $title,
        public string $content,
        public string $date,
        public string $userId,
    )
    {

    }
}
