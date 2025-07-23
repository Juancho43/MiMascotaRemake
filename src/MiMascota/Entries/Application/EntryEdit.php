<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use DateTime;

final readonly class EntryEdit
{

    public function __construct(private EntryRepository $repository)
    {

    }

    public function __invoke(
        User $user,
        string             $entry_id,
        string             $title,
        string             $content,
        DateTime $date
    ) : Entry
    {
        $entry = $this->repository->search($entry_id);
        if ($entry === null) {
            throw new ModelNotFound('Entry', 'id', $entry_id);
        }
        if ($entry->getJournal()->getUser() !== $user) {
            throw new UserPermissionDenied('edit this entry.');
        }
        $entry->setTitle($title);
        $entry->setContent($content);
        $entry->setDate($date);

        $this->repository->save($entry);
        return $entry;
    }
}
