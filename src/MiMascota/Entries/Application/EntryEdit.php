<?php

namespace App\MiMascota\Entries\Application;

use App\MiMascota\Entries\Application\Command\EditEntryCommand;
use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Application\Query\EntryGetByIdQuery;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Entries\Domain\ValueObject\EntryContent;
use App\MiMascota\Entries\Domain\ValueObject\EntryDate;
use App\MiMascota\Entries\Domain\ValueObject\EntryTitle;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use DateTime;

final readonly class EntryEdit
{

    public function __construct(
        private EntryRepository $repository,
        private EntryGetById $entryGetById,
        private UserGetById $userGetById
    )
    {

    }

    public function __invoke(EditEntryCommand $command) : Entry
    {
        $entry = $this->entryGetById->__invoke(new EntryGetByIdQuery($command->entryId));
        $user = $this->userGetById->__invoke(new GetUserByIdQuery($command->userId));
        if ($entry->getJournal()->getUser() !== $user) {
            throw new UserPermissionDenied('edit this entry.');
        }
        $entry->setTitle(EntryTitle::generate($command->title));
        $entry->setContent(EntryContent::generate($command->content));
        $entry->setDate(EntryDate::generate($command->date));
        $entry->getTimeStamp()->update();
        $this->repository->save($entry);
        return $entry;
    }
}
