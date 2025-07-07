<?php

namespace App\MiMascota\Entries\Domain;

use App\MiMascota\Entries\Domain\Entry;

interface EntryRepository
{
    public function search(string $id): ?Entry;

    public function save(Entry $entry): void;

    public function remove(Entry $entry): void;
}
