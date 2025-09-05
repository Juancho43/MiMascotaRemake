<?php

namespace App\MiMascota\Animals\Application\Query;

final readonly class GetAnimalByJournalSlugQuery
{
    public function __construct(
        public string $journalSlug
    )
    {

    }
}
