<?php

namespace App\Tests\MiMascota\Journals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Application\JournalCreator;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JournalCreatorTest extends KernelTestCase
{
    private JournalCreator $journalCreator;
    private JournalRepository $repository;
    private User $user;
    public function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->repository = $this->createMock(JournalRepository::class);
        $this->journalCreator = new JournalCreator($this->repository);
        $this->user = User::create(
            '123e4567-e89b-12d3-a456-426614174001',
            UserName::create('asddd'),
            UserTelephone::create('2222222222'),
            UserEmail::create('asdasd@asdas.com'),
            UserPassword::create('dsadsadas')
        );

    }
    public function test__invoke()
    {
        $animal = Animal::create(
            '123e4567-e89b-12d3-a456-426614174000',
            'Fido',
            'A friendly dog',
            'Brown',
            'Medium',
            'Labrador',
            'male',
            new \DateTimeImmutable('2020-01-01'),
            '20.00'
        );
        $this->repository->expects($this->once())
            ->method('save');
        $journal = $this->journalCreator->__invoke(
            $this->user,
            $animal->getName(),
            $animal->getBreed(),
            $animal->getBirthDate(),
            $animal->getGender(),
            $animal->getWeight(),
            $animal->getSize(),
            $animal->getColor(),
            $animal->getDescription()
        );

        $this->assertEquals($journal['animal']['name'], $animal->getName());
    }
}
