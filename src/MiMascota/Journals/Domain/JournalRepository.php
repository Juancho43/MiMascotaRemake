<?php

namespace App\MiMascota\Journals\Domain;


interface JournalRepository
{
    public function search(string $id): ?Journal;


    public function save(Journal $journal): void;

    public function update(Journal $journal): void;
}
