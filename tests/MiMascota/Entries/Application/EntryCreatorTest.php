<?php

namespace App\Tests\MiMascota\Entries\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Application\EntryCreator;
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

class EntryCreatorTest extends KernelTestCase
{

    private EntryCreator $entryCreator;
    private $entryRepository;
    private $journalRepository;
    private Entry $entry;
    private Journal $journal;
    public function setUp() : void
    {
        self::bootKernel();
        $this->entryRepository = $this->createMock(EntryRepository::class);
        $this->journalRepository = $this->createMock(JournalRepository::class);
        $this->entryCreator = new EntryCreator($this->entryRepository, $this->journalRepository);
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(), 'test-journal', $this->createMock(User::class), $this->createMock(Animal::class));
        $this->entry = EntryMock::generate(Uuid::uuid4()->toString(),date: new \DateTime(), journal: $this->journal);
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

        $response = $this->entryCreator->__invoke(
            $this->journal->getId(),
            $this->entry->getTitle(),
            $this->entry->getContent(),
            $this->entry->getDate()->format('Y-m-d')
        );
        $this->assertIsArray($response);
        $this->assertEquals($this->journal->getId(), $response['journal_id']);
        $this->assertEquals($this->entry->getTitle(), $response['title']);
        $this->assertEquals($this->entry->getContent(), $response['content']);
    }
    public function test__invokeFails()
    {
        $id = Uuid::uuid4()->toString();
        $this->expectException(ModelNotFound::class);
        $this->journalRepository->expects($this->once())
            ->method('search')
            ->with($id)
            ->willReturn(null);
        $response = $this->entryCreator->__invoke(
            $id,
            $this->entry->getTitle(),
            $this->entry->getContent(),
            $this->entry->getDate()->format('Y-m-d')
        );
    }
}
