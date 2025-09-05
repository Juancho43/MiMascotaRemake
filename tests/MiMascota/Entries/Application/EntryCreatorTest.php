<?php

namespace App\Tests\MiMascota\Entries\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Application\Command\CreateEntryCommand;
use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Application\EntryCreator;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Journals\Application\JournalGetById;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\EntryMock;
use App\Tests\MiMascota\Shared\JournalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntryCreatorTest extends TestCase
{

    private EntryCreator $entryCreator;
    private $entryRepository;
    private $journalRepository;
    private Entry $entry;
    private Journal $journal;
    public function setUp() : void
    {

        $this->entryRepository = $this->createMock(EntryRepository::class);
        $this->journalRepository = $this->createMock(JournalRepository::class);
        $this->entryCreator = new EntryCreator($this->entryRepository, new JournalGetById($this->journalRepository));
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(),  $this->createMock(User::class), $this->createMock(Animal::class));
        $this->entry = EntryMock::generate(Uuid::uuid4()->toString(), journal: $this->journal,date: '2024-02-02');
    }
    public function test__invoke()
    {
        $this->journalRepository->expects($this->once())
            ->method('search')
            ->with($this->journal->getId())
            ->willReturn($this->journal);
        $this->journal->addEntry($this->entry);
        $this->entryRepository->expects($this->once())
            ->method('save');
        $command = new CreateEntryCommand(

            $this->journal->getId(),
            $this->entry->getTitle(),
            $this->entry->getContent(),
            $this->entry->getDate()
        );
        $response = $this->entryCreator->__invoke($command);
        $this->assertInstanceOf(Entry::class, $response);
        $this->assertEquals($this->journal, $response->getJournal());
        $this->assertEquals($this->entry->getTitle(), $response->getTitle());
        $this->assertEquals($this->entry->getContent(), $response->getContent());
    }
    public function test__invokeFails()
    {
        $id = Uuid::uuid4()->toString();
        $this->expectException(ModelNotFound::class);
        $this->journalRepository->expects($this->once())
            ->method('search')
            ->with($id)
            ->willReturn(null);
        $command = new CreateEntryCommand(
            $id,
            $this->entry->getTitle(),
            $this->entry->getContent(),
            $this->entry->getDate()
        );
        $response = $this->entryCreator->__invoke($command);
    }
}
