<?php

namespace App\Tests\MiMascota\Journals\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Journals\Application\JournalGetAllData;
use App\MiMascota\Journals\Application\Query\GetAllJournalsByUserIdQuery;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JournalGetAllDataTest extends TestCase
{

    private JournalGetAllData $journalGetAllData;
    private AnimalRepository $repository;
    private User $user;

    public function setUp(): void
    {

        $this->repository = $this->createMock(AnimalRepository::class);
        $this->journalGetAllData = new JournalGetAllData($this->repository);
        $this->user = UserMock::generate(Uuid::uuid4()->toString());
        for ($i = 0; $i < 5; $i++) {
            $this->user->addJournal(JournalMock::generate(
                Uuid::uuid4()->toString(),
                $this->user,
                AnimalMock::generate(
                    Uuid::uuid4()->toString(),
                    'Animal ',
                    'Description of animal ',
                    'Color ' ,
                    'small',
                    'Breed ' ,
                    'male',
                    '2020-01-01',
                    10.0
                )
            ));


        }
    }

    public function test__invoke()
    {
        $this->repository->expects($this->once())
            ->method('getAnimals')
            ->with($this->user->getId())->
            willReturn($this->user->getJournals()->toArray())
        ;
       $result = $this->journalGetAllData->__invoke(new GetAllJournalsByUserIdQuery($this->user->getId()));
       $this->assertCount(5,$result);

        $this->assertInstanceOf(Journal::class, $result[0]);
    }
}
