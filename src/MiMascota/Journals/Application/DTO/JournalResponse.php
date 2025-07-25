<?php

namespace App\MiMascota\Journals\Application\DTO;

use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Journals\Domain\Journal;

final readonly class JournalResponse
{
    public static function generate(Journal $journal) : array
    {
        return [
            'id' => $journal->getId(),
            'animal' => AnimalResponse::generate($journal->getAnimal()),
        ];
    }
}
