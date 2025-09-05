<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalEdit;
use App\MiMascota\Animals\Application\AnimalGetByJournalId;
use App\MiMascota\Animals\Application\Command\EditAnimalCommand;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Animals\Domain\Exceptions\AnimalNotFoundByJournalId;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalEditTest extends TestCase
{
    private AnimalEdit $animalEdit;
    private Animal $animal;
    private User $user;
    private Journal $journal;
    private AnimalRepository $animalRepository;
    private UserRepository $userRepository;

    public function setUp(): void
    {

        $this->animalRepository = $this->createMock(AnimalRepository::class);
       $this->userRepository = $this->createMock(UserRepository::class);
        $this->animalEdit = new AnimalEdit($this->animalRepository,new AnimalGetByJournalId($this->animalRepository),
            new UserGetById($this->userRepository));
        $this->user = UserMock::generate(Uuid::uuid4()->toString());
        $this->animal = AnimalMock::generate(Uuid::uuid4()->toString());
        $this->journal = JournalMock::generate(Uuid::uuid4()->toString(), $this->user,$this->animal);
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
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $command = new EditAnimalCommand(
            $this->user->getId(),
            $this->journal->getId(),
            $newAnimal->getName(),
            $newAnimal->getDescription(),
            $newAnimal->getColor(),
            $newAnimal->getSize(),
            $newAnimal->getBreed(),
            $newAnimal->getGender(),
            $newAnimal->getBirthDate(),
            $newAnimal->getWeight()
        );
        $response = $this->animalEdit->__invoke($command);
        $this->assertEquals($newAnimal->getName(), $this->animal->getName());
        $this->assertEquals($newAnimal->getDescription(), $this->animal->getDescription());


    }



    public function test__invokeUserNotAuthorized()
    {
        $this->expectException(UserPermissionDenied::class);
        $unauthorizedUser = UserMock::generate(Uuid::uuid4()->toString());
        $this->animalRepository->expects($this->once())
        ->method('getAnimal')
        ->with($this->animal->getJournal()->getId())
        ->willReturn($this->animal);
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($unauthorizedUser->getId())
            ->willReturn($unauthorizedUser);
        $command = new EditAnimalCommand(
            $unauthorizedUser->getId(),
            $this->journal->getId(),
            'New Name',
            'New Description',
            'Black',
            'Medium',
            $this->animal->getBreed(),
            $this->animal->getGender(),
            $this->animal->getBirthDate(),
            $this->animal->getWeight()
        );
        $this->animalEdit->__invoke($command);
    }
}
