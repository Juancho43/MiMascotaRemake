<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Domain\EntryRepository;

class EntryGetOne
{
    public function __construct(
        private readonly EntryRepository $entryRepository,
    )
    {

    }

    public function __invoke(string $id): array
    {

        return [
            'entry' => $this->entryRepository->search($id),
            'photos' => $this->entryRepository->getPhotos($id),
        ];
    }
}
