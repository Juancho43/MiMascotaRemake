<?php

namespace App\MiMascota\Entries\Application\Command;

class CreateEntryCommand
{
    public function __construct(
        public string $journalId,
        public string $title,
        public string $content,
        public string $date
    )
    {

    }
}
