<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Application\Query\GetAnimalByJournalSlugQuery;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class AnimalGetByJournalId
{

    public function __construct(private AnimalRepository $animalRepository)
    {

    }
    public function __invoke(GetAnimalByJournalSlugQuery $query) : Animal
    {
        $animal = $this->animalRepository->getAnimal($query->journalSlug);
        if ($animal === null) {
            throw new ModelNotFound('animal', 'journal slug ', $query->journalSlug);
        }
        return $animal;
    }

}
