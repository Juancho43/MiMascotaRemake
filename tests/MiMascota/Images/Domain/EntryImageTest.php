<?php

namespace App\Tests\MiMascota\Images\Domain;

use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Images\Domain\EntryImage;
use App\MiMascota\Images\Domain\Image;
use PHPUnit\Framework\TestCase;

class EntryImageTest extends TestCase
{

    public function testCreate()
    {
        $entryImage = EntryImage::create(
            id: '123',
            entry: $this->createMock(Entry::class),
            image: $this->createMock(Image::class),
            position: 1
        );
        $this->assertInstanceOf(EntryImage::class, $entryImage);
        $this->assertEquals('123', $entryImage->getId());
    }

    public function testGetEntry()
    {
        $entry = $this->createMock(Entry::class);
        $entryImage = EntryImage::create(
            id: '123',
            entry: $entry,
            image: $this->createMock(Image::class),
            position: 1
        );
        $this->assertSame($entry, $entryImage->getEntry());
        $this->assertInstanceOf(Entry::class, $entryImage->getEntry());
    }

    public function testGetImage()
    {
        $entry = $this->createMock(Entry::class);
        $entryImage = EntryImage::create(
            id: '123',
            entry: $entry,
            image: $this->createMock(Image::class),
            position: 1
        );
        $this->assertSame($entry, $entryImage->getEntry());
        $this->assertInstanceOf(Image::class, $entryImage->getImage());
    }

    public function testGetPosition()
    {

        $entryImage = EntryImage::create(
            id: '123',
            entry: $this->createMock(Entry::class),
            image: $this->createMock(Image::class),
            position: 1
        );
        $this->assertEquals(1, $entryImage->getPosition());
    }


}
