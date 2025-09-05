<?php

namespace App\MiMascota\Animals\Application\Command;
class CreateAnimalCommand
{
    public function __construct(
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
