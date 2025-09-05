<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\Command\SoftDeleteAnimalCommand;
use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use OpenApi\Attributes\Get;

final readonly class AnimalSoftDelete
{
    public function __construct(
        private AnimalRepository $repository,
        private AnimalGetById $animalGetById,
    )
    {
    }

    public function __invoke(SoftDeleteAnimalCommand $command): Animal
    {
        $animal = $this->animalGetById->__invoke(new GetAnimalByIdQuery($command->animalId));
        $animal->getSoftDelete()->markAsDeleted();
        $animal->getTimeStamp()->update();
        $this->repository->save($animal);
        return $animal;
    }

}
