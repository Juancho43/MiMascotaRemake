<?php

namespace App\MiMascota\Animals\Application\Command;

class EditAnimalCommand
{
    public function __construct(
        public string $userId,
        public string $journalId,
        public string $name,
        public string $description,
        public string $color,
        public string $size,
        public string $breed,
        public string $gender,
        public string $birthDate,
        public float $weight
    )
    {

    }
}
