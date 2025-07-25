<?php

namespace App\Tests\MiMascota\Entries\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Application\EntryCreator;
use App\MiMascota\Entries\Application\EntryEdit;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\EntryMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntryEditTest extends KernelTestCase
{

    private EntryEdit $entryEdit;
    private EntryRepository $entryRepository;
    private Entry $entry;
    private Journal $journal;
    private User $user;
    public function setUp() : void
    {
        self::bootKernel();
        $this->entryRepository = $this->createMock(EntryRepository::class);
        $this->entryEdit = new EntryEdit($this->entryRepository);
        $this->user = UserMock::generateUser(Uuid::uuid4()->toString(), 'test user');
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(), 'test-journal', $this->user, $this->createMock(Animal::class));
        $this->entry = EntryMock::generate(Uuid::uuid4()->toString(),date: new \DateTime(), journal: $this->journal);
    }
    public function test__invoke()
    {
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($this->entry->getId())
            ->willReturn($this->entry);
        $newEntry = EntryMock::generate($this->entry->getId(),  new \DateTime(),  $this->journal, 'updated-title', 'updated-content');
        $response = $this->entryEdit->__invoke(
            $this->user,
            $this->entry->getId(),
            $newEntry->getTitle(),
            $newEntry->getContent(),
            $this->entry->getDate()
        );
        $this->assertIsArray($response);
        $this->assertEquals($this->entry->getTitle(), $response['title']);
        $this->assertEquals($this->entry->getContent(), $response['content']);
        $this->assertEquals($newEntry->getTitle(), $response['title']);
        $this->assertEquals($newEntry->getContent(), $response['content']);
    }
    public function test__invokeFails()
    {
        $id = Uuid::uuid4()->toString();
        $this->expectException(ModelNotFound::class);
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($id)
            ->willReturn(null);

        $response = $this->entryEdit->__invoke(
            $this->user,
            $id,
            $this->entry->getTitle(),
            $this->entry->getContent(),
            $this->entry->getDate()
        );
    }

    public function test__invokeFailsUserDenied () : void
    {
        $user = UserMock::generateUser(Uuid::uuid4()->toString(), 'test user');
        $this->expectException(UserPermissionDenied::class);
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($this->entry->getId())
            ->willReturn($this->entry);
        $this->entryEdit->__invoke(
            $user,
            $this->entry->getId(),
            $this->entry->getTitle(),
            $this->entry->getContent(),
            $this->entry->getDate()
        );

    }

}
