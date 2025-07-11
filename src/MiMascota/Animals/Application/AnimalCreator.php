<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use Ramsey\Uuid\Uuid;

class AnimalCreator
{
    public function  __construct(
      private AnimalRepository $repository,
    )
    {

    }

    public function __invoke(string $name, string $breed, int $age, string $gender, string $weight): Animal
    {
        $animal = Animal::create(Uuid::uuid4()->toString(), $name,$breed, $age, $gender,$weight);
        $this->repository->save($animal);
        return $animal;
    }
}
