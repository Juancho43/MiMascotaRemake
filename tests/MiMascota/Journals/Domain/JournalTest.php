<?php

namespace App\Tests\MiMascota\Journals\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\User;
use PHPUnit\Framework\TestCase;

class JournalTest extends TestCase
{

    public function testGetTimeStamp()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $this->assertInstanceOf(TimeStamp::class, $journal->getTimeStamp());
    }

    public function testGetId()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $this->assertEquals('12345', $journal->getId());
    }

    public function testGetUser()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $this->assertInstanceOf(User::class, $journal->getUser());
    }

    public function testAddEntry()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $entry = $this->createMock(Entry::class);
        $journal->addEntry($entry);
        $this->assertTrue($journal->getEntries()->contains($entry));
    }

    public function testGetSoftDelete()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $this->assertInstanceOf(SoftDelete::class, $journal->getSoftDelete());
    }

    public function testGetAnimal()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $this->assertInstanceOf(Animal::class, $journal->getAnimal());
    }

    public function testCreate()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $this->assertInstanceOf(Journal::class, $journal);

    }

    public function testGetEntries()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $entry = $this->createMock(Entry::class);
        $entry2 = $this->createMock(Entry::class);
        $journal->addEntry($entry);
        $journal->addEntry($entry2);
        $entries = $journal->getEntries();
        $this->assertCount(2, $entries);
    }

    public function testGetOneEntyById()
    {
        $journal = Journal::create(
            id: '12345',
            user: $this->createMock(User::class),
            animal: $this->createMock(Animal::class)
        );
        $entry = $this->createMock(Entry::class);
        $entry2 = $this->createMock(Entry::class);
        $journal->addEntry($entry);
        $journal->addEntry($entry2);
        $entryResult = $journal->getEntryById($entry->getId());
        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertEquals($entry->getId(), $entryResult->getId());

    }
}
