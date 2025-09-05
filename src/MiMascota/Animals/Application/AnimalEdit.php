<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\Command\EditAnimalCommand;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Animals\Application\Query\GetAnimalByJournalSlugQuery;
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
use App\MiMascota\Journals\Domain\ValueObject\JournalSlug;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use DateTimeImmutable;

final readonly class AnimalEdit
{

    public function __construct(
        private AnimalRepository $animalRepository,
        private AnimalGetByJournalId $getAnimalByJournalId,
        private UserGetById $getUserById,
    )
    {

    }
    public function __invoke(EditAnimalCommand $command) : Animal
    {
        $user = $this->getUserById->__invoke(new GetUserByIdQuery($command->userId));
        $animal =  $this->getAnimalByJournalId->__invoke(new GetAnimalByJournalSlugQuery($command->journalId));
        if($animal->getJournal()->getUser() !== $user) {
            throw new UserPermissionDenied('edit this animal');
        }
        $animal->setName(AnimalName::generate($command->name));
        $animal->getJournal()->setSlug(JournalSlug::create(SlugGenerator::generate($command->name)));
        $animal->setDescription(AnimalDescription::generate($command->description));
        $animal->setColor(AnimalColor::generate($command->color));
        $animal->setSize(AnimalSize::generate($command->size));
        $animal->setBreed(AnimalBreed::generate($command->breed));
        $animal->setGender(AnimalGender::generate($command->gender));
        $animal->setBirthDate(AnimalBirthDate::generate($command->birthDate));
        $animal->setWeight(AnimalWeight::generate($command->weight));
        $animal->getTimeStamp()->update();
        $this->animalRepository->save($animal);
        return $animal;
    }
}
