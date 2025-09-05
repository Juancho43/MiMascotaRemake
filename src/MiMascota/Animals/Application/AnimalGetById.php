<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class AnimalGetById
{
    public function __construct(
        private AnimalRepository $animalRepository
    )
    {

    }

    public function __invoke(GetAnimalByIdQuery $query) : Animal
    {
        $animal = $this->animalRepository->search($query->animalId);
        if (null === $animal) {
            throw new ModelNotFound('animal', 'id', $query->animalId);
        }
        return $animal;
    }
}
