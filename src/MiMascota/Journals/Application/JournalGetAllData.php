<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;

final readonly class JournalGetAllData
{

    public function __construct(private AnimalRepository $repository )
    {

    }
    public function __invoke(string $userId) : array
    {
        return $this->repository->getAnimals($userId);
    }
}
