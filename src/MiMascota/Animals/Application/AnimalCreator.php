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

    public function __invoke(

        string $name,
        string $description,
        string $color,
        string $size,
        string $breed,
        string $gender,
        \DateTime $birthDate,
        float $weight
    ): Animal
    {
        $animal = Animal::create(Uuid::uuid4()->toString(),  $name, $description, $color, $size, $breed, $gender, $birthDate, $weight);
        $this->repository->save($animal);
        return $animal;
    }
}
