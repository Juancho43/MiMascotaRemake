<?php

namespace App\MiMascota\Journals\Application\Query;

class GetJournalByIdQuery
{
    public function __construct(
        public string $journalId
    ) {}
}
