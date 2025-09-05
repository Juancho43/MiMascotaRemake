<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\Command\CreateAnimalCommand;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Animals\Domain\ValueObject\AnimalBirthDate;
use App\MiMascota\Animals\Domain\ValueObject\AnimalBreed;
use App\MiMascota\Animals\Domain\ValueObject\AnimalColor;
use App\MiMascota\Animals\Domain\ValueObject\AnimalDescription;
use App\MiMascota\Animals\Domain\ValueObject\AnimalGender;
use App\MiMascota\Animals\Domain\ValueObject\AnimalName;
use App\MiMascota\Animals\Domain\ValueObject\AnimalSize;
use App\MiMascota\Animals\Domain\ValueObject\AnimalWeight;
use Ramsey\Uuid\Uuid;

final readonly class AnimalCreator
{
    public function  __construct(
      private AnimalRepository $repository,
    )
    {
    }

    public function __invoke(CreateAnimalCommand $command) : Animal
    {
        $animal = Animal::create(
            Uuid::uuid4()->toString(),
            AnimalName::generate($command->name),
            AnimalDescription::generate($command->description),
            AnimalColor::generate($command->color),
            AnimalSize::generate($command->size),
            AnimalBreed::generate($command->breed),
            AnimalGender::generate($command->gender),
            AnimalBirthDate::generate($command->birthDate),
            AnimalWeight::generate($command->weight)
        );


        $this->repository->save($animal);
        return $animal;
    }
}
