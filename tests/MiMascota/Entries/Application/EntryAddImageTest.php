<?php

namespace App\Tests\MiMascota\Entries\Application;

use App\MiMascota\Animals\Application\AnimalAddImage;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Entries\Application\EntryAddImage;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Entries\Domain\EntryRepository;
use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\EntryMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EntryAddImageTest extends KernelTestCase
{
    private EntryAddImage $entryAddImage;
    private EntryRepository $repository;
    private SaveImage $saveImage;
    private Entry $entry;

    public function setUp(): void
    {
        self::bootKernel();
        $this->repository = $this->createMock(EntryRepository::class);
        $this->saveImage = new SaveImage($this->createMock(ImageRepository::class));
        $this->entryAddImage = new EntryAddImage($this->saveImage,$this->repository);
        $this->entry = EntryMock::generate(Uuid::uuid4()->toString(),new \DateTime(),$this->createMock(Journal::class));
    }
    public function test__invoke()
    {
        $this->repository
            ->expects($this->once())
            ->method('search')
            ->willReturn($this->entry);
        $imageFile = $this->createMock(UploadedFile::class);


        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($this->entry);
        $this->entryAddImage->__invoke($imageFile,$this->entry->getId(), 1);

        $this->assertCount(1, $this->entry->getImages());

    }

    public function test__invokeFails()
    {
        $this->repository
            ->expects($this->once())
            ->method('search')
            ->willReturn(null);

        $imageFile = $this->createMock(UploadedFile::class);

        $this->expectException(ModelNotFound::class);

        $this->entryAddImage->__invoke($imageFile, Uuid::uuid4()->toString(), 1);
    }
}
