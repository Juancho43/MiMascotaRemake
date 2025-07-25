<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalEdit;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Animals\Domain\Exceptions\AnimalNotFoundByJournalId;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalEditTest extends KernelTestCase
{
    private AnimalEdit $animalEdit;
    private Animal $animal;
    private User $user;
    private Journal $journal;
    private AnimalRepository $animalRepository;

    public function setUp(): void
    {
        self::bootKernel();
        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->animalEdit = new AnimalEdit($this->animalRepository);
        $this->user = UserMock::generateUser(Uuid::uuid4()->toString());
        $this->animal = AnimalMock::generate(Uuid::uuid4()->toString());
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(),'slug', $this->user,$this->animal);
        $this->animal->setJournal($this->journal);
        $this->user->addJournal($this->journal);
    }
    public function test__invoke()
    {
        $newAnimal = AnimalMock::generate(Uuid::uuid4()->toString(),'Perro','Perro fiel');
        $this->animalRepository->expects($this->once())
            ->method('getAnimal')
            ->with($this->animal->getJournal()->getId())
            ->willReturn($this->animal);
        $response = $this->animalEdit->__invoke($this->user,$this->journal->getId(),$newAnimal->getName(), $newAnimal->getDescription(), $newAnimal->getColor(), $newAnimal->getSize(), $newAnimal->getBreed(), $newAnimal->getGender(), $newAnimal->getBirthDate(), $newAnimal->getWeight());
        $this->assertEquals($newAnimal->getName(), $this->animal->getName());
        $this->assertEquals($newAnimal->getDescription(), $this->animal->getDescription());
        $this->assertEquals(AnimalResponse::generate($this->animal),$response);

    }

    public function test__invokeAnimalNotFound()
    {
        $this->expectException(ModelNotFound::class);
        $this->animalRepository->expects($this->once())
            ->method('getAnimal')
            ->with($this->journal->getId())
            ->willReturn(null);
        $this->animalEdit->__invoke($this->user, $this->journal->getId(), 'New Name', 'New Description', 'Black', 'Medium',$this->animal->getBreed(), $this->animal->getGender(), $this->animal->getBirthDate(), $this->animal->getWeight());
    }

    public function test__invokeUserNotAuthorized()
    {
        $this->expectException(\Exception::class);
        $unauthorizedUser = UserMock::generateUser(Uuid::uuid4()->toString());
        $this->animalRepository->expects($this->once())
            ->method('getAnimal')
            ->with($this->journal->getId())
            ->willReturn($this->animal);
        $this->animalEdit->__invoke($unauthorizedUser, $this->journal->getId(), 'New Name', 'New Description', 'Black', 'Medium',$this->animal->getBreed(), $this->animal->getGender(), $this->animal->getBirthDate(), $this->animal->getWeight());
    }
}
