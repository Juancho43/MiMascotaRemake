<?php

namespace App\Tests\MiMascota\Entries\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Application\Command\SoftDeleteEntryCommand;
use App\MiMascota\Entries\Application\EntryGetById;
use App\MiMascota\Entries\Application\EntrySoftDelete;
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

class EntrySoftDeleteTest extends TestCase
{
    private EntrySoftDelete $entrySoftDelete;
    private EntryRepository $entryRepository;
    private JournalRepository $journalRepository;
    private Entry $entry;
    private Journal $journal;
    public function setUp(): void
    {
        $this->entryRepository  = $this->createMock(EntryRepository::class);
        $this->journalRepository = $this->createMock(JournalRepository::class);
        $this->entrySoftDelete = new EntrySoftDelete($this->entryRepository, new EntryGetById($this->entryRepository));
        $this->journal= JournalMock::generate(Uuid::uuid4()->toString(),  $this->createMock(User::class), $this->createMock(Animal::class));
        $this->entry = EntryMock::generate(Uuid::uuid4()->toString(), $this->journal, '2024-02-02','Test Entry', 'This is a test entry content.');
    }

    public function test__invoke():void
    {
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($this->entry->getId())
            ->willReturn($this->entry);
        $this->entrySoftDelete->__invoke(new SoftDeleteEntryCommand($this->entry->getId()));
        $this->assertTrue($this->entry->getSoftDelete()->isDeleted());
    }
    public function test__invokeFails(): void
    {
        $wrongId = Uuid::uuid4()->toString();
        $this->expectException(ModelNotFound::class);
        $this->entryRepository->expects($this->once())
            ->method('search')
            ->with($wrongId)
            ->willReturn(null);
        $this->entrySoftDelete->__invoke(new SoftDeleteEntryCommand($wrongId));
    }
}
