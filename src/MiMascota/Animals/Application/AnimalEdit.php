<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use DateTimeImmutable;

final readonly class AnimalEdit
{

    public function __construct(private AnimalRepository $animalRepository)
    {

    }
    public function __invoke(
        User $user,
        string $journal_id,
        string $name,
        string $description,
        string $color,
        string $size,
        string $breed,
        string $gender,
        DateTimeImmutable $birthDate,
        float $weight
    ) : array
    {

        $animal = $this->animalRepository->getAnimal($journal_id);
        if ($animal === null) {
            throw new ModelNotFound('animal', 'journal id ', $journal_id);
        }
        if($animal->getJournal()->getUser() !== $user) {
            throw new UserPermissionDenied('edit this animal.');
        }
        $animal->setName($name);
        $animal->setDescription($description);
        $animal->setColor($color);
        $animal->setSize($size);
        $animal->setBreed($breed);
        $animal->setGender($gender);
        $animal->setBirthDate($birthDate);
        $animal->setWeight($weight);
        $animal->getTimeStamp()->update();
        $this->animalRepository->save($animal);
        return AnimalResponse::generate($animal);
    }
}
