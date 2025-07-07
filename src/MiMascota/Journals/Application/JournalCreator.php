<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Application\AnimalCreator;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\User;
use Ramsey\Uuid\Uuid;

final readonly class JournalCreator
{
    public function __construct(
     private JournalRepository $repository,
        private AnimalCreator $animalCreator,
    )
    {}
    public function __invoke(User $user,string $name, string $breed, int $age, string $gender): Journal
    {
        $journal = Journal::create(Uuid::uuid4()->toString(), $user,$this->animalCreator->__invoke($name, $breed, $age, $gender));
        $this->repository->save($journal);
        return $journal;
    }
}
