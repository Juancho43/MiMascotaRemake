<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalAddImage;
use App\MiMascota\Animals\Application\AnimalGetById;
use App\MiMascota\Animals\Application\Command\AddAnimalImageCommand;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\Tests\MiMascota\Shared\AnimalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AnimalAddImageTest extends TestCase
{

    private AnimalAddImage $animalAddImage;
    private AnimalRepository $animalRepository;
    private SaveImage $saveImage;
    private Animal $animal;

    public function setUp(): void
    {

        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->saveImage = new SaveImage($this->createMock(ImageRepository::class));
        $this->animalAddImage = new AnimalAddImage($this->saveImage,new AnimalGetById($this->animalRepository),$this->animalRepository);
        $this->animal = AnimalMock::generate(Uuid::uuid4()->toString());
    }
    public function test__invoke()
    {
        $this->animalRepository
            ->expects($this->once())
            ->method('search')
            ->willReturn($this->animal);
        $imageFile = $this->createMock(UploadedFile::class);


        $this->animalRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->animal);
        $command = new AddAnimalImageCommand(
            $this->animal->getId(),
            $imageFile,
            1
        );
        $this->animalAddImage->__invoke($command);

        $this->assertCount(1, $this->animal->getImages());

    }


}
