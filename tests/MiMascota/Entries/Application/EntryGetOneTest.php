<?php

namespace App\Tests\MiMascota\Entries\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Application\EntryGetById;
use App\MiMascota\Entries\Application\EntryGetOne;
use App\MiMascota\Entries\Application\Query\EntryGetByIdQuery;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\EntryMock;

use App\Tests\MiMascota\Shared\JournalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class EntryGetOneTest extends TestCase
{

    private EntryGetById $entryGetOne;
    private EntryRepository $entryRepository;
    private JournalRepository $journalRepository;
    private Entry $entry;
    private Journal $journal;
    public function setUp(): void
    {
        $this->entryRepository  = $this->createMock(EntryRepository::class);
        $this->journalRepository = $this->createMock(JournalRepository::class);
        $this->entryGetOne = new EntryGetById($this->entryRepository);
        $this->journal= JournalMock::generate(Uuid::uuid4()->toString(),  $this->createMock(User::class), $this->createMock(Animal::class));
        $this->entry = EntryMock::generate(Uuid::uuid4()->toString(), $this->journal,'2024-02-02', 'Test Entry', 'This is a test entry content.');
    }

    public function test__invoke()
    {
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($this->entry->getId())
            ->willReturn($this->entry);

        $response = $this->entryGetOne->__invoke(new EntryGetByIdQuery($this->entry->getId()));
        $this->assertEquals($this->entry, $response);
    }
    public function test__invokeFails()
    {
        $wrongId = Uuid::uuid4()->toString();
        $this->expectException(ModelNotFound::class);
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($wrongId)
            ->willReturn(null);
        ;
        $this->entryGetOne->__invoke(new EntryGetByIdQuery($wrongId));
    }
}
