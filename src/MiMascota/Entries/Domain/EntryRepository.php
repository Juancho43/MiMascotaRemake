<?php

namespace App\MiMascota\Entries\Domain;


interface EntryRepository
{
    public function search(string $id): ?Entry;

    public function save(Entry $entry): void;

    public function remove(Entry $entry): void;

    public function getPhotos(string $id): array;
}
