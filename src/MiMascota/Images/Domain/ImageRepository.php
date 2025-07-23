<?php

namespace App\MiMascota\Images\Domain;


interface ImageRepository
{
    public function search(string $id): ?Image;

    public function save(Image $image): void;

    public function remove(Image $image): void;

    public function getFromAnimalImage(string $id, string $animalId): ?AnimalImage;
    public function getFromEntryImage(string $id, string $entryId): ?EntryImage;
    public function getFromUserImage(string $id, string $userId): ?UserImage;
}
