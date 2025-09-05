<?php

namespace App\Tests\MiMascota\Animals\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Images\Domain\HaveImages;
use App\MiMascota\Journals\Domain\Journal;
use App\Tests\MiMascota\Shared\AnimalMock;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AnimalTest extends TestCase
{
    private Animal $animal;
    public function setUp(): void
    {
        $this->animal =AnimalMock::generate(Uuid::uuid4()->toString());
    }


    public function testCreate()
    {

        $this->assertEquals('Test Animal', $this->animal->getName());
        $this->assertEquals('This is a test animal', $this->animal->getDescription());
        $this->assertEquals('Brown', $this->animal->getColor());
        $this->assertEquals('medium', $this->animal->getSize());
        $this->assertEquals('Labrador', $this->animal->getBreed());

    }

    public function testSetJournal()
    {
        $journal = $this->createMock(Journal::class);
        $this->animal->setJournal($journal);
        $this->assertSame($journal, $this->animal->getJournal());
    }

    public function testSetImage()
    {
        $animalImage = $this->createMock(\App\MiMascota\Images\Domain\AnimalImage::class);
        $this->animal->addImage($animalImage);
        $this->assertSame($animalImage, $this->animal->getImage(0));
    }
    public function testGetImages()
    {

        $this->animal->addImage($this->createMock(\App\MiMascota\Images\Domain\AnimalImage::class));
        $this->animal->addImage($this->createMock(\App\MiMascota\Images\Domain\AnimalImage::class));
        $this->assertCount(2, $this->animal->getImages());
    }
    public function testAnimalCanHaveOnlyThreeImages()
    {
        $this->animal->addImage($this->createMock(\App\MiMascota\Images\Domain\AnimalImage::class));
        $this->animal->addImage($this->createMock(\App\MiMascota\Images\Domain\AnimalImage::class));
        $this->animal->addImage($this->createMock(\App\MiMascota\Images\Domain\AnimalImage::class));
        $this->expectExceptionObject(new HaveImages('animal', 3));
        $this->animal->addImage($this->createMock(\App\MiMascota\Images\Domain\AnimalImage::class));
    }
    public function testSetPost()
    {
        $this->animal->addPost($this->createMock(\App\MiMascota\Posts\Domain\Post::class));
        $this->assertNotEmpty($this->animal->getPosts());
    }
}
