<?php

namespace App\MiMascota\Images\Domain;


use App\MiMascota\Entries\Domain\Entry;

class EntryImage
{
    private function __construct(
        private readonly string $id,
        private Entry $entry,
        private Image $image,
        private int $position,

    ) {

    }

    public static function create($id, Entry $entry, Image $image, int $position): self{
        return new self(
            id: $id,
            entry: $entry,
            image: $image,
            position: $position
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEntry(): Entry
    {
        return $this->entry;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function getPosition(): int
    {
        return $this->position;
    }



}
