<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalGetImages;
use App\MiMascota\Animals\Application\Query\GetAnimalByJournalSlugQuery;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Animals\Domain\Exceptions\AnimalNotFoundByJournalId;
use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\JournalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalGetImagesTest extends TestCase
{
    private AnimalGetImages $animalGetImages;
    private AnimalRepository $animalRepository;
    private Animal $animal;
    private Journal $journal;
    public function setUp(): void
    {

        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->animalGetImages = new AnimalGetImages($this->animalRepository);
        $this->animal = AnimalMock::generate(Uuid::uuid4()->toString());
        for ($i = 0; $i < 3; $i++) {
            $this->animal->addImage($this->createMock(AnimalImage::class));
        }
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(),$this->createMock(User::class), $this->animal);
        $this->animal->setJournal($this->journal);

    }
    public function test__invoke()
    {
        $this->animalRepository->expects($this->once())
            ->method('getWithImagesFromJournal')
            ->with($this->journal->getId())
            ->willReturn($this->animal);
        $images = $this->animalGetImages->__invoke(new GetAnimalByJournalSlugQuery($this->journal->getId()));
        $this->assertCount(3, $images->getImages());
    }
    public function test__invokeWithWrongId()
    {
        $this->expectException(ModelNotFound::class);
        $id = Uuid::uuid4()->toString();
        $this->animalRepository->expects($this->once())
            ->method('getWithImagesFromJournal')
            ->with($id)
            ->willReturn(null);
        $images = $this->animalGetImages->__invoke(new GetAnimalByJournalSlugQuery($id));

    }
}
