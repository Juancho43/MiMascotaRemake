<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalAddImage;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\Image;
use App\Tests\MiMascota\Shared\AnimalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AnimalAddImageTest extends KernelTestCase
{

    private AnimalAddImage $animalAddImage;
    private AnimalRepository $animalRepository;
    private SaveImage $saveImage;
    private Animal $animal;

    public function setUp(): void
    {
        self::bootKernel();
        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->saveImage = $this->createMock(SaveImage::class);
        $this->animalAddImage = new AnimalAddImage($this->saveImage,$this->animalRepository);
        $this->animal = AnimalMock::generate(Uuid::uuid4()->toString());
    }
    public function test__invoke()
    {
        $this->animalRepository
            ->expects($this->once())
            ->method('search')
            ->willReturn($this->animal);
        $imageFile = $this->createMock(UploadedFile::class);


        $this->saveImage->expects($this->once())
            ->method('__invoke')
            ->with(
                $imageFile,
                'animal',
                $this->animal->getId()
            )
            ->willReturn($this->createMock(Image::class));
        $this->animalRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->animal);
        $this->animalAddImage->__invoke($imageFile,$this->animal->getId(), 1);

        $this->assertCount(1, $this->animal->getImages());
    }
}
