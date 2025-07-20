<?php

namespace App\Tests\MiMascota\Animals\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Domain\Journal;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AnimalTest extends TestCase
{
    private Animal $animal;
    public function setUp(): void
    {
        $this->animal = $this->generateAnimal(
            Uuid::uuid4()->toString(),
            'Fido',
            'A friendly dog',
            'Brown',
            'Medium',
            'Labrador',
            'male',
            new DateTimeImmutable('2020-01-01'),
            25.0
        );
    }

    private function generateAnimal($id, $name, $description, $color, $size, $breed, $gender, $birthDate, $weight): Animal
    {
        return Animal::create($id, $name, $description, $color, $size, $breed, $gender, $birthDate, $weight);
    }
    public function testCreate()
    {
        $this->assertInstanceOf(Animal::class, $this->animal);
        $this->assertEquals('Fido', $this->animal->getName());
        $this->assertEquals('A friendly dog', $this->animal->getDescription());
        $this->assertEquals('Brown', $this->animal->getColor());
        $this->assertEquals('Medium', $this->animal->getSize());
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
        $this->expectException(\Exception::class);
        $this->animal->addImage($this->createMock(\App\MiMascota\Images\Domain\AnimalImage::class));
    }
    public function testSetPost()
    {
        $this->animal->addPost($this->createMock(\App\MiMascota\Posts\Domain\Post::class));
        $this->assertNotEmpty($this->animal->getPosts());
    }
}
