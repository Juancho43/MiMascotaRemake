<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class AnimalSoftDelete
{
    public function __construct(
        private AnimalRepository $repository,
    )
    {
    }

    public function __invoke(string $id): void
    {
        $animal = $this->repository->search($id);

        if ($animal === null) {
            throw new ModelNotFound("animal");
        }

        $animal->getSoftDelete()->markAsDeleted();
        $this->repository->save($animal);

    }

}
