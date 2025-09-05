<?php

namespace App\Tests\MiMascota\Entries\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Application\Command\EditEntryCommand;
use App\MiMascota\Entries\Application\EntryCreator;
use App\MiMascota\Entries\Application\EntryEdit;
use App\MiMascota\Entries\Application\EntryGetById;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\Tests\MiMascota\Shared\EntryMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntryEditTest extends TestCase
{

    private EntryEdit $entryEdit;
    private EntryRepository $entryRepository;
    private UserRepository $userRepository;
    private Entry $entry;
    private Journal $journal;
    private User $user;
    public function setUp() : void
    {

        $this->entryRepository = $this->createMock(EntryRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->entryEdit = new EntryEdit($this->entryRepository,new EntryGetById($this->entryRepository), new UserGetById($this->userRepository));
        $this->user = UserMock::generate(Uuid::uuid4()->toString(), 'test user');
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(), $this->user, $this->createMock(Animal::class));
        $this->entry = EntryMock::generate(Uuid::uuid4()->toString(), journal: $this->journal, date: '2025-08-05');
    }
    public function test__invoke()
    {
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($this->entry->getId())
            ->willReturn($this->entry);
        $newEntry = EntryMock::generate($this->entry->getId(),   $this->journal, '2025-08-05', 'updated title', 'updated content');
        $command = new EditEntryCommand(
            $this->entry->getId(),
            $newEntry->getTitle(),
            $newEntry->getContent(),
            $this->entry->getDate(),
            $this->user->getId()
        );
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($this->entry->getId())
            ->willReturn($this->entry);
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $response = $this->entryEdit->__invoke($command);
        $this->assertInstanceOf(Entry::class, $response);
        $this->assertEquals($this->entry->getTitle(), $response->getTitle());
        $this->assertEquals($this->entry->getContent(), $response->getContent());
        $this->assertEquals($newEntry->getTitle(), $response->getTitle());
        $this->assertEquals($newEntry->getContent(), $response->getContent());
    }
    public function test__invokeFails()
    {
        $id = Uuid::uuid4()->toString();
        $this->expectException(ModelNotFound::class);
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($id)
            ->willReturn(null);
        $command = new EditEntryCommand(
            $id,
            $this->entry->getTitle(),
            $this->entry->getContent(),
            $this->entry->getDate(),
            $this->user->getId()
        );
        $response = $this->entryEdit->__invoke($command);
    }

    public function test__invokeFailsUserDenied () : void
    {
        $user = UserMock::generate(Uuid::uuid4()->toString(), 'test user');
        $this->expectException(UserPermissionDenied::class);
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($this->entry->getId())
            ->willReturn($this->entry);
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($user->getId())
            ->willReturn($user);
        $command = new EditEntryCommand(
            $this->entry->getId(),
            $this->entry->getTitle(),
            $this->entry->getContent(),
            $this->entry->getDate(),
            $user->getId()
        );
        $this->entryEdit->__invoke($command);

    }

}
