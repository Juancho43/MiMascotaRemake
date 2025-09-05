<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalGetById;
use App\MiMascota\Animals\Application\AnimalSoftDelete;
use App\MiMascota\Animals\Application\Command\SoftDeleteAnimalCommand;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\Tests\MiMascota\Shared\AnimalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalSoftDeleteTest extends KernelTestCase
{
    private AnimalSoftDelete $animalSoftDelete;
    private AnimalRepository $animalRepository;

    public function setUp(): void
    {
        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->animalSoftDelete = new AnimalSoftDelete($this->animalRepository,new AnimalGetById($this->animalRepository));

    }
    public function test__invoke()
    {
        $animal =  AnimalMock::generate(Uuid::uuid4()->toString());
        $this->animalRepository->expects($this->once())
            ->method('search')
            ->with($animal->getId())
            ->willReturn($animal);
        $this->animalRepository->expects($this->once())
            ->method('save')
            ->with($animal);
        $this->animalSoftDelete->__invoke(new SoftDeleteAnimalCommand($animal->getId()));
        $this->assertTrue($animal->getSoftDelete()->isDeleted());

    }
    public function test__invokeThrowsModelNotFound()
    {
        $this->expectException(ModelNotFound::class);
        $this->expectExceptionMessage('animal');

        $this->animalRepository->expects($this->once())
            ->method('search')
            ->with('non-existing-id')
            ->willReturn(null);

        $this->animalSoftDelete->__invoke(new SoftDeleteAnimalCommand('non-existing-id'));
    }
}
