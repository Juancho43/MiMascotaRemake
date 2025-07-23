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

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function getAnimal(): Animal
    {
        return $this->animal;
    }

    public function getId(): string
    {
        return $this->id;
    }




}
