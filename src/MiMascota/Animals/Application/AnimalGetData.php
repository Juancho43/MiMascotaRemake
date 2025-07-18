<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;

class AnimalGetData
{
    public function __construct(private AnimalRepository $animalRepository)
    {

    }
    public function __invoke(string $journal_id) : ?Animal
    {
        return $this->animalRepository->getAnimal($journal_id);
    }
}
