<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\DTO\AnimalImagesResponse;
use App\MiMascota\Animals\Domain\AnimalRepository;

use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class AnimalGetImages
{

    public function __construct(
        private AnimalRepository $animalRepository,
    ) {
    }

    public function __invoke(string $journalId): array
    {
        $animal = $this->animalRepository->getWithImagesFromJournal($journalId);
        if ($animal === null) {
            throw new ModelNotFound("animal",'journal id', $journalId);
        }
        return AnimalImagesResponse::generate($animal);
    }
}
