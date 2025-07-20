<?php

namespace App\Tests\MiMascota\Journals\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class JournalTest extends TestCase
{
    private Journal $journal;

    public function setUp() : void
    {
        $this->journal = $this->generateJournal();
    }

    private function generateJournal(): Journal
    {
        $animal = $this->createMock(Animal::class);
        return Journal::create(
            id: Uuid::uuid4()->toString(),
            slug: $animal->getName(),
            user: $this->createMock(User::class),
            animal: $animal
        );
    }
    public function testGetTimeStamp()
    {

        $this->assertInstanceOf(TimeStamp::class, $this->journal->getTimeStamp());
    }

    public function testGetId()
    {
        $this->assertNotNull( $this->journal->getId());
    }

    public function testGetUser()
    {

        $this->assertInstanceOf(User::class, $this->journal->getUser());
    }

    public function testAddEntry()
    {

        $entry = $this->createMock(Entry::class);
        $this->journal->addEntry($entry);
        $this->assertTrue($this->journal->getEntries()->contains($entry));
    }

    public function testGetSoftDelete()
    {

        $this->assertInstanceOf(SoftDelete::class, $this->journal->getSoftDelete());
    }

    public function testGetAnimal()
    {

        $this->assertInstanceOf(Animal::class, $this->journal->getAnimal());
    }


    public function testGetEntries()
    {

        $entry = $this->createMock(Entry::class);
        $entry2 = $this->createMock(Entry::class);
        $this->journal->addEntry($entry);
        $this->journal->addEntry($entry2);
        $entries = $this->journal->getEntries();
        $this->assertCount(2, $entries);
    }

    public function testGetOneEntyById()
    {

        $entry = $this->createMock(Entry::class);
        $entry2 = $this->createMock(Entry::class);
        $this->journal->addEntry($entry);
        $this->journal->addEntry($entry2);
        $entryResult = $this->journal->getEntryById($entry->getId());
        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertEquals($entry->getId(), $entryResult->getId());

    }
}
