<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Application\AnimalGetData;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Entries\Domain\EntryRepository;

final readonly class JournalGetData
{

    public function __construct(private AnimalGetData $animalGetData,private EntryRepository $entryRepository)
    {

    }

    public function __invoke(string $journal_id) : array
    {
        $result['entryCount'] = $this->entryRepository->getCount($journal_id);
        $result['animal'] = $this->animalGetData->__invoke($journal_id);
        return $result;
    }

}
