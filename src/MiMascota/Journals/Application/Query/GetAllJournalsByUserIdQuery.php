<?php

namespace App\MiMascota\Journals\Application\Query;

class GetAllJournalsByUserIdQuery
{
    public function __construct(
        public string $userId
    )
    {

    }
}
