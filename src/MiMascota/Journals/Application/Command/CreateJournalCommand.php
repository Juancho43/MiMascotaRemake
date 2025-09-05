<?php

namespace App\MiMascota\Journals\Application\Command;

use App\MiMascota\Users\Domain\User;
use DateTimeImmutable;

class CreateJournalCommand
{
    public function __construct(
        public string $userId,
        public string $name,
        public string $breed,
        public string $age,
        public string $gender,
        public string $weight,
        public string $size,
        public string $color,
        public string $description
    )
    {

    }
}
