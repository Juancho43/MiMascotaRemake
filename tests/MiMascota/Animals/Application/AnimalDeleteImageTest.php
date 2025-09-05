<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalDeleteImage;
use App\MiMascota\Animals\Application\AnimalGetById;
use App\MiMascota\Animals\Application\Command\DeleteAnimalImageCommand;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Images\Application\DeleteImage;
use App\MiMascota\Images\Application\GetImageById;
use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Images\Domain\IDeleteImage;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\JournalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalDeleteImageTest extends TestCase
{
    private AnimalDeleteImage $animalDeleteImage;
    private AnimalRepository $repository;
    private ImageRepository $imageRepository;
    private Animal $animal;
    private Journal $journal;
    private IDeleteImage $deleteImage;

    public function setUp(): void
    {

        $this->repository = $this->createMock(AnimalRepository::class);

        $this->imageRepository = $this->createMock(ImageRepository::class);
        $this->deleteImage = $this->createMock(IDeleteImage::class);
        $this->animalDeleteImage = new AnimalDeleteImage(
            $this->repository,
            new AnimalGetById($this->repository),
            $this->imageRepository,
            new DeleteImage(
                $this->imageRepository,
                new GetImageById($this->imageRepository),
                $this->deleteImage
            )
        );
        $this->animal = AnimalMock::generate(Uuid::uuid4()->toString());
        for ($i = 0; $i < 3; $i++) {
            $this->animal->addImage($this->createMock(AnimalImage::class));
        }
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(),$this->createMock(User::class),
            $this->animal);
        $this->animal->setJournal($this->journal);
    }
    public function test__invoke()
    {
        $this->repository->expects($this->once())
            ->method('search')
            ->with($this->animal->getId())
            ->willReturn($this->animal);
        $this->imageRepository->expects($this->once())
            ->method('getFromAnimalImage')
            ->with($this->animal->getImages()->first()->getImage()->getId(), $this->animal->getId())
            ->willReturn($this->animal->getImages()[0]);
        $this->imageRepository->expects($this->once())
            ->method('search')
            ->with($this->animal->getImages()->first()->getImage()->getId())
            ->willReturn($this->animal->getImages()->first()->getImage());
        $command = new DeleteAnimalImageCommand(
            $this->animal->getId(),
            $this->animal->getImages()->first()->getImage()->getId()
        );
        $this->animalDeleteImage->__invoke($command);
        $this->assertCount(2, $this->animal->getImages()->toArray());
    }

    public function test__invokeWithWrongAnimalId()
    {
        $this->expectException(\App\MiMascota\Shared\Domain\ModelNotFound::class);
        $id = Uuid::uuid4()->toString();
        $this->repository->expects($this->once())
            ->method('search')
            ->with($id)
            ->willReturn(null);

        $command = new DeleteAnimalImageCommand(
            $id,
            Uuid::uuid4()->toString()
        );
        $this->animalDeleteImage->__invoke($command);
    }

    public function test__invokeWithWrongImageId()
    {
        $this->expectException(\App\MiMascota\Shared\Domain\ModelNotFound::class);
        $id = Uuid::uuid4()->toString();
        $this->repository->expects($this->once())
            ->method('search')
            ->with($this->animal->getId())
            ->willReturn($this->animal);
        $this->imageRepository->expects($this->once())
            ->method('getFromAnimalImage')
            ->with($id, $this->animal->getId())
            ->willReturn(null);
        $this->animalDeleteImage->__invoke(new DeleteAnimalImageCommand($this->animal->getId(), $id));
    }
}
