<?php

namespace App\MiMascota\Journals\Application;

use App\MiMascota\Animals\Application\AnimalGetByJournalId;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Application\Query\GetAnimalByJournalSlugQuery;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Journals\Application\Query\GetJournalByIdQuery;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class JournalGetData
{

    public function __construct(
        private JournalRepository $journalRepository,
    )
    {

    }

   public function __invoke(GetJournalByIdQuery $query) : Journal
   {
       $journal = $this->journalRepository->getOneBySlug($query->journalId);
       if ($journal === null) {
           throw new ModelNotFound('journal','slug',$query->journalId);
       }
       return $journal;
   }

}
