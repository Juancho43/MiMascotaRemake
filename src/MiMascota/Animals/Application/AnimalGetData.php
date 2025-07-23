<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Animals\Domain\Exceptions\AnimalNotFoundByJournalId;

class AnimalGetData
{

    public function __construct(private AnimalRepository $animalRepository)
    {

    }
    public function __invoke(string $journal_id) : ?Animal
    {
        $animal = $this->animalRepository->getAnimal($journal_id);
        if ($animal === null) {
            throw new AnimalNotFoundByJournalId($journal_id);
        }
        return $animal ;
    }
}
