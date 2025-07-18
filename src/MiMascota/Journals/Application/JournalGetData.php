<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Application\AnimalGetData;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;

class JournalGetData
{

    public function __construct(private AnimalGetData $animalGetData)
    {

    }

    public function __invoke(string $journal_id)
    {
        return AnimalResponse::fromAnimal($this->animalGetData->__invoke($journal_id));

    }

}
