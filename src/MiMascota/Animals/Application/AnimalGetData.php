<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class AnimalGetData
{

    public function __construct(private AnimalRepository $animalRepository)
    {

    }
    public function __invoke(string $journal_id) : array
    {
        $animal = $this->animalRepository->getAnimal($journal_id);
        if ($animal === null) {
            throw new ModelNotFound('animal', 'journal id ', $journal_id);
        }
        return AnimalResponse::generate($animal);
    }
}
