<?php

namespace App\MiMascota\Journals\Domain;


use Doctrine\Common\Collections\Collection;

interface JournalRepository
{
    public function search(string $id): ?Journal;


    public function save(Journal $journal): void;
    public function getOneById(string $id): ?array;

    public function update(Journal $journal): void;

    public function getEntries(string $journalId, int $page, int $limit): Collection;
}
