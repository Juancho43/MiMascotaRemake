<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\ValueObject\AnimalBirthDate;
use App\MiMascota\Animals\Domain\ValueObject\AnimalBreed;
use App\MiMascota\Animals\Domain\ValueObject\AnimalColor;
use App\MiMascota\Animals\Domain\ValueObject\AnimalDescription;
use App\MiMascota\Animals\Domain\ValueObject\AnimalGender;
use App\MiMascota\Animals\Domain\ValueObject\AnimalName;
use App\MiMascota\Animals\Domain\ValueObject\AnimalSize;
use App\MiMascota\Animals\Domain\ValueObject\AnimalWeight;
use App\MiMascota\Journals\Application\Command\CreateJournalCommand;
use App\MiMascota\Journals\Application\DTO\JournalResponse;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Journals\Domain\ValueObject\JournalSlug;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\User;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final readonly class JournalCreator
{

    public function __construct(
        private JournalRepository $repository,
        private UserGetById $userGetById,
    )
    {}
    public function __invoke(
     CreateJournalCommand $command
    ):Journal
    {
        $user = $this->userGetById->__invoke(new GetUserByIdQuery($command->userId));
        $animal = Animal::create(
            Uuid::uuid4()->toString(),
            AnimalName::generate($command->name),
            AnimalDescription::generate($command->description),
            AnimalColor::generate($command->color),
            AnimalSize::generate($command->size),
            AnimalBreed::generate($command->breed),
            AnimalGender::generate($command->gender),
            AnimalBirthDate::generate($command->age),
            AnimalWeight::generate($command->weight)
        );
        $slug = JournalSlug::create(SlugGenerator::generate($animal->getName()));
        $journal = Journal::create(Uuid::uuid4()->toString(),$slug,$user,$animal);
        $animal->setJournal($journal);
        $this->repository->save($journal);
        return $journal;
    }
}
