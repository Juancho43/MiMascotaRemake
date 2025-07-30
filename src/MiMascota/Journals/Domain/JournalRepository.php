<?php

namespace App\MiMascota\Journals\Domain;

interface JournalRepository
{
    public function search(string $id): ?Journal;


    public function save(Journal $journal): void;
    public function getOneById(string $id): ?array;

    public function getEntries(string $journalId, int $page, int $limit): iterable;
    public function getAnimal(string $journalId): ?array;
}
