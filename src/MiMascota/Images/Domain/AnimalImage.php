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

    public static function create(
        string $id,
        Animal $animal,
        Image $image,
        int $position
    ): self {
        return new self($id, $animal, $image, $position);
    }

}
