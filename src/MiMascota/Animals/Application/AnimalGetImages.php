<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\DTO\AnimalImagesResponse;
use App\MiMascota\Animals\Application\Query\GetAnimalByJournalSlugQuery;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;

use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class AnimalGetImages
{

    public function __construct(
        private AnimalRepository $animalRepository,
    ) {
    }

    public function __invoke(GetAnimalByJournalSlugQuery $query) : Animal
    {
        $animal = $this->animalRepository->getWithImagesFromJournal($query->journalSlug);
        if ($animal === null) {
            throw new ModelNotFound("animal",'journal slug', $query->journalSlug);
        }
        return $animal;
    }
}
