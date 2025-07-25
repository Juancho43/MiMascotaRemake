<?php

namespace App\Tests\MiMascota\Journals\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Application\JournalSoftDelete;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\JournalMock;
use App\Tests\MiMascota\Shared\UserMock;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JournalSoftDeleteTest extends KernelTestCase
{
    private $journalSoftDelete;
    private $journalRepository;
    private Journal $journal;

    public function setUp() : void
    {
        self::bootKernel();
        $this->journalRepository = $this->createMock(JournalRepository::class);
        $this->journalSoftDelete = new JournalSoftDelete($this->journalRepository);
        $this->journal = Journal::create('ididi','dsds',UserMock::generateUser('adada'),AnimalMock::generate('2222'));
    }
    public function test__invoke()
    {
        $this->journalRepository->expects($this->once())
            ->method('search')
            ->with($this->journal->getId())
            ->willReturn($this->journal);
        $this->journalRepository->expects($this->once())
            ->method('save')
            ->with($this->journal);
        $this->journalSoftDelete->__invoke($this->journal->getId());
        $this->assertTrue($this->journal->getSoftDelete()->isDeleted());
    }

    public function test_invokeFails()
    {
        $this->expectException(ModelNotFound::class);

        $this->journalRepository->expects($this->once())
            ->method('search')
            ->with($this->journal->getId())
            ->willReturn(null);

        $this->journalSoftDelete->__invoke($this->journal->getId());
    }
}
