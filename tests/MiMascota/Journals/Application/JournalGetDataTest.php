<?php

namespace App\Tests\MiMascota\Journals\Application;

use App\MiMascota\Animals\Application\AnimalGetData;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Journals\Application\JournalGetAllData;
use App\MiMascota\Journals\Application\JournalGetData;
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
    private AnimalGetData $repository;
    private User $user;
    private Animal $animal;
    public function setUp(): void
    {
        self::bootKernel();
        $this->repository = $this->createMock(AnimalGetData::class);
        $this->journalGetData = new JournalGetData($this->repository);
        $this->user = UserMock::generateUser(Uuid::uuid4()->toString());
        for ($i = 0; $i < 1; $i++) {
            $this->animal = $animal = AnimalMock::generate(
                Uuid::uuid4()->toString(),
                'Animal ' . $i,
                'Description of animal ' . $i,
                'Color ' . $i,
                'small ',
                'Breed ' . $i,
                'male',
                '2020-01-01',
                10.0
            );
            $journal = JournalMock::generate(
                Uuid::uuid4()->toString(),
                'slug',
                $this->user,
                $animal
            );
            $animal->setJournal($journal);
            $this->user->addJournal($journal);

        }
    }

    public function test__invoke()
    {
        $journalId = $this->user->getJournals()->first()->getId();
        $this->repository->expects($this->once())
            ->method('__invoke')
            ->with($journalId)
            ->willReturn($this->user->getJournals()->first()->getAnimal());

        $response = $this->journalGetData->__invoke($journalId);
        $this->assertEquals(AnimalResponse::generate($this->animal),$response);

    }
}
