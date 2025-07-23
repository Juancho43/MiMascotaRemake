<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Animals\Domain\Exceptions\AnimalNotFound;
use App\MiMascota\Animals\Domain\Exceptions\AnimalNotFoundByJournalId;

class AnimalGetImages
{

    public function __construct(
        private AnimalRepository $animalRepository,
    ) {
    }

    public function __invoke(string $journalId): array
    {
        $animal = $this->animalRepository->getWithImagesFromJournal($journalId);
        if ($animal === null) {
            throw new AnimalNotFoundByJournalId($journalId);
        }

        return ['id'=>$animal->getId(), 'images' => $animal->getImages()->toArray()];
    }
}
