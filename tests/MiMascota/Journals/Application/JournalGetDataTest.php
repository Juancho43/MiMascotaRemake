<?php

namespace App\Tests\MiMascota\Journals\Application;

use App\MiMascota\Animals\Application\AnimalGetData;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Journals\Application\JournalGetAllData;
use App\MiMascota\Journals\Application\JournalGetData;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JournalGetDataTest extends KernelTestCase
{
   private JournalGetData $journalGetData;
private AnimalGetData $animalGetData;
private AnimalRepository $animalRepository;
private User $user;
private Animal $animal;
private Journal $journal;

public function setUp(): void
{
    self::bootKernel();
    $this->animalRepository = $this->createMock(AnimalRepository::class);

    // Create AnimalGetData with the mocked repository
    $this->animalGetData = new AnimalGetData($this->animalRepository);

    // Use the instance you created instead of getting it from container
    $this->journalGetData = new JournalGetData($this->animalGetData);

    $this->user = UserMock::generateUser(Uuid::uuid4()->toString());
    $this->animal = AnimalMock::generate(
        Uuid::uuid4()->toString(),
        'Animal ',
        'Description of animal ',
        'Color ',
        'small ',
        'Breed ',
        'male',
        '2020-01-01',
        10.0
    );
    $this->journal = JournalMock::generate(
        Uuid::uuid4()->toString(),
        'slug',
        $this->user,
        $this->animal
    );
    $this->animal->setJournal($this->journal);
    $this->user->addJournal($this->journal);
}

    public function test__invoke()
    {
        $journalId = $this->animal->getJournal()->getId();
        $this->animalRepository->expects($this->once())
            ->method('getAnimal')
            ->with($journalId)
            ->willReturn($this->animal);
        $response = $this->journalGetData->__invoke($journalId);
        $this->assertEquals(AnimalResponse::generate($this->animal),$response);

    }
}
