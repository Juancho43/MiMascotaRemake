<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalCreator;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\Tests\MiMascota\Shared\AnimalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalCreatorTest extends KernelTestCase
{
    private $animalCreator;
    private $animalRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->animalCreator = new AnimalCreator($this->animalRepository);
    }
    public function test__invoke()
    {
        $animal = AnimalMock::generate(Uuid::uuid4()->toString());
        $this->animalRepository->expects($this->once())
            ->method('save')
            ->with($this->equalTo($animal));

        $animalnew = $this->animalCreator->__invoke($animal->getName(),
            $animal->getDescription(),
            $animal->getColor(),
            $animal->getSize(),
            $animal->getBreed(),
            $animal->getGender(),
            $animal->getBirthDate(),
            $animal->getWeight()
        );
        $this->assertEquals($animal->getId(), $animalnew->getId());


    }
}
