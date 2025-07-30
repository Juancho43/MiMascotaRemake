<?php

namespace App\MiMascota\Entries\Domain;


use Doctrine\Common\Collections\Collection;

interface EntryRepository
{
    public function getCount(string $journalId): int;
    public function search(string $id): ?Entry;
    public function getMany(string $journalId, int $page = 1, int $limit = 3):array;

    public function save(Entry $entry): void;

    public function remove(Entry $entry): void;

    public function getPhotos(string $id): array;
}
