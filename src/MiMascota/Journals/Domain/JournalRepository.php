<?php

namespace App\MiMascota\Journals\Domain;

interface JournalRepository
{
    public function search(string $id): ?Journal;


    public function save(Journal $journal): void;
    public function getOneBySlug(string $slug): ?Journal;

    public function getEntries(string $journalSlug, int $page, int $limit): array;
    public function getAnimal(string $journalSlug): ?array;
}
