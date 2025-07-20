<?php

namespace App\Tests\MiMascota\Entries\Domain;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Images\Domain\EntryImage;
use App\MiMascota\Journals\Domain\Journal;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class EntryTest extends TestCase
{
    private Entry $entry;

    public function setUp(): void
    {
        $this->entry = $this->generateEnty(
            Uuid::uuid4()->toString(),
            'Test Entry Title',
            'This is a test entry content.',
            '2023-10-01 12:00:00',
            $this->createMock(Journal::class)
        );
    }

    private function generateEnty($id,$title,$content,$date,$journal): Entry
    {
        return Entry::create(
            $id,
            $title,
            $content,
            new \DateTime($date),
            $journal
        );
    }

    public function testGetDate()
    {
        $this->assertInstanceOf(\DateTime::class, $this->entry->getDate());
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
        $this->assertEquals('This is a test entry content.', $this->entry->getContent());
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
