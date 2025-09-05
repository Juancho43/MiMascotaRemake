<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Journals\Application\Query\GetAllJournalsByUserIdQuery;


final readonly class JournalGetAllData
{

    public function __construct(private AnimalRepository $repository )
    {

    }
    public function __invoke(GetAllJournalsByUserIdQuery $query) : array
    {
        return $this->repository->getAnimals($query->userId);


    }
}
