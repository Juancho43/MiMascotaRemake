<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Application\DTO\JournalResponse;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final readonly class JournalCreator
{

    public function __construct(
     private JournalRepository $repository,
    )
    {}
    public function __invoke(
        User $user,
        string $name,
        string $breed,
        DateTimeImmutable $age,
        string $gender,
        string $weight,
        string $size,
        string $color,
        string $description
    ): array
    {
        $animal = Animal::create(
            Uuid::uuid4()->toString(),
            $name,
            $description,
            $color,
            $size,
            $breed,
            $gender,
            $age,
            $weight
        );
        $journal = Journal::create(Uuid::uuid4()->toString(), SlugGenerator::generate($animal->getName()),$user,$animal);
        $animal->setJournal($journal);
        $this->repository->save($journal);
        return JournalResponse::generate($journal);
    }
}
