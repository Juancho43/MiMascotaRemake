<?php

namespace App\MiMascota\Animals\Application\Command;

final readonly class SoftDeleteAnimalCommand
{
    public function __construct(
        public string $animalId
    )
    {

    }
}
