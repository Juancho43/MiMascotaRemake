<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use Ramsey\Uuid\Uuid;

final readonly class AnimalCreator
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
        \DateTimeImmutable $birthDate,
        float $weight
    ): Animal
    {
        $animal = Animal::create(Uuid::uuid4()->toString(),  $name, $description, $color, $size, $breed, $gender, $birthDate, $weight);
        $this->repository->save($animal);
        return $animal;
    }
}
