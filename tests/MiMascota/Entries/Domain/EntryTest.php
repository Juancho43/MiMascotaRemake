<?php

namespace App\Tests\MiMascota\Entries\Domain;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Images\Domain\EntryImage;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\EntryMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class EntryTest extends TestCase
{
    private Entry $entry;
    private Journal $journal;
    private User $user;

    public function setUp(): void
    {
        $this->user = UserMock::generate(Uuid::uuid4()->toString());
        $this->journal = JournalMock::generate(
            Uuid::uuid4()->toString(),
            $this->user,
            AnimalMock::generate(Uuid::uuid4()->toString())
        );
        $this->entry =EntryMock::generate(Uuid::uuid4()->toString(),$this->journal,'2024-09-02' ) ;
    }



    public function testGetDate()
    {
        $this->assertEquals('2024-09-02', $this->entry->getDate());
    }

    public function testAddImage()
    {
        $this->entry->addImage($this->createMock(EntryImage::class));
        $this->assertCount(1, $this->entry->getImages());
    }

    public function testEntryCanHaveOnlyThreeImages()
    {
        $this->entry->addImage($this->createMock(EntryImage::class));
        $this->entry->addImage($this->createMock(EntryImage::class));
        $this->entry->addImage($this->createMock(EntryImage::class));
        $this->expectException(\Exception::class);
        $this->entry->addImage($this->createMock(EntryImage::class));
        $this->assertCount(3, $this->entry->getImages());
    }

    public function testRemoveImage()
    {
        $this->entry->addImage($this->createMock(EntryImage::class));
        $this->entry->removeImage($this->entry->getImages()->first());
        $this->assertCount(0, $this->entry->getImages());
    }

    public function testGetContent()
    {
        $this->assertEquals('mock content', $this->entry->getContent());
    }

    public function testGetJournal()
    {
        $this->assertInstanceOf(Journal::class, $this->entry->getJournal());
    }

    public function testGetImages()
    {
        $imageMock = $this->createMock(EntryImage::class);
        $this->entry->addImage($imageMock);
        $this->assertInstanceOf(EntryImage::class, $this->entry->getImages()->first());
        $this->assertEquals($imageMock, $this->entry->getImages()->first());
    }
}
