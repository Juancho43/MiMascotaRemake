<?php

namespace App\MiMascota\Journals\Application\DTO;

use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Journals\Domain\Journal;

class JournalCreatedResponse
{
    public function __construct(
        public string $id,
        public AnimalResponse $animalResponse
    )
    {

    }

    public static function fromJournal(Journal $journal) : self
    {
        return new self($journal->getId(),AnimalResponse::fromAnimal($journal->getAnimal()));
    }
}
