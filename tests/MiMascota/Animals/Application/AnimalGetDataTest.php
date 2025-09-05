<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalGetByJournalId;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Application\Query\GetAnimalByJournalSlugQuery;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalGetDataTest extends TestCase
{

    private AnimalGetByJournalId $animalGetData;
    private $animalRepository;

    private Animal $animal;
    private Journal $journal;

    private User $user;
    public function setUp() : void{

        $this->animalRepository = $this->createMock('App\MiMascota\Animals\Domain\AnimalRepository');
        $this->animalGetData = new AnimalGetByJournalId($this->animalRepository);
        $this->animal = AnimalMock::generate(Uuid::uuid4()->toString());
        $this->user = UserMock::generate(Uuid::uuid4()->toString());
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(),$this->user,$this->animal);
    }
    public function test__invoke()
    {
        $this->animalRepository->expects($this->once())
            ->method('getAnimal')
            ->with($this->journal->getId())
            ->willReturn($this->animal);
        $response = $this->animalGetData->__invoke(new GetAnimalByJournalSlugQuery($this->journal->getId()));
        $this->assertEquals($this->animal, $response);

    }

    public function test__invokeAnimalNotFound()
    {
        $this->expectException(ModelNotFound::class);
        $this->animalRepository->expects($this->once())
            ->method('getAnimal')
            ->with($this->journal->getId())
            ->willReturn(null);
             $response = $this->animalGetData->__invoke(new GetAnimalByJournalSlugQuery($this->journal->getId()));
    }
}
