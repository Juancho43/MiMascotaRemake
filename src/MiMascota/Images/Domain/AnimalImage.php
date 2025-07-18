<?php

namespace App\MiMascota\Images\Domain;

use App\MiMascota\Animals\Domain\Animal;

class AnimalImage
{
    public function __construct(
        private readonly string $id,
        private Animal $animal,
        private Image $image,
        private int $position,

    ) {

    }
    public function setAnimal(?Animal $animal): void
    {
        $this->animal = $animal;
    }
}
