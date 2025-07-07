<?php

namespace App\MiMascota\Journals\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Users\Domain\User;

final class Journal
{

    /** @var array<Entry> */
    private array $entries = [];
    /** @var array<Image> */
    private array $images = [];
    private function __construct(
        private readonly string $id,
        private readonly User $user,
        private readonly Animal $animal,
    ) {
    }


    public static function create(string $id, User $user,Animal $animal): self
    {
        return new self($id, $user, $animal);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return sprintf(
            'Journals ID: %s, User: %s, Animal: %s',
            $this->id,
            $this->user->getId(),
            $this->animal
        );
    }

    public function getAnimal(): Animal
    {
        return $this->animal;
    }


}
