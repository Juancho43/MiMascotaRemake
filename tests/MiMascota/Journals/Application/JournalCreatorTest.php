<?php

namespace App\Tests\MiMascota\Journals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Application\Command\CreateJournalCommand;
use App\MiMascota\Journals\Application\JournalCreator;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JournalCreatorTest extends TestCase
{
    private JournalCreator $journalCreator;
    private JournalRepository $repository;
    private UserRepository $userRepository;
    private User $user;
    public function setUp(): void
    {

        $this->repository = $this->createMock(JournalRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->journalCreator = new JournalCreator($this->repository,new UserGetById($this->userRepository));
        $this->user = UserMock::generate(Uuid::uuid4()->toString());

    }
    public function test__invoke()
    {
        $animal = AnimalMock::generate(Uuid::uuid4()->toString());
        $this->repository->expects($this->once())
            ->method('save');
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $command = new CreateJournalCommand(
            $this->user->getId(),
            $animal->getName(),
            $animal->getBreed(),
            $animal->getBirthDate(),
            $animal->getGender(),
            $animal->getWeight(),
            $animal->getSize(),
            $animal->getColor(),
            $animal->getDescription()
        );
        $journal = $this->journalCreator->__invoke($command);

        $this->assertEquals($journal->getAnimal()->getName(), $animal->getName());
    }
}
