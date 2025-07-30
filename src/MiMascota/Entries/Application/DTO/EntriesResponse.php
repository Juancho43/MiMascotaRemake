<?php

namespace App\MiMascota\Entries\Application\DTO;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Journals\Domain\Journal;
use Doctrine\Common\Collections\Collection;

class EntriesResponse
{
    public static function generate(Journal $entries): array
    {

      $entries->getEntries()->map(function (Entry $entry) use (&$response) {
          $response[] = EntryResponse::generate($entry);
      });


        return $response;

    }
}
