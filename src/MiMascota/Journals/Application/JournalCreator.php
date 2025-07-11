<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Application\AnimalCreator;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\User;
use Ramsey\Uuid\Uuid;

final readonly class JournalCreator
{
    public function __construct(
     private JournalRepository $repository,
    )
    {}
    public function __invoke(User $user,string $name, string $breed, int $age, string $gender, string $weight): Journal
    {
        $animal = Animal::create(Uuid::uuid4()->toString(), $name,$breed, $age, $gender,$weight);
        $journal = Journal::create(Uuid::uuid4()->toString(), $user,$animal);
        $animal->setJournal($journal);
        $this->repository->save($journal);
        return $journal;
    }
}
