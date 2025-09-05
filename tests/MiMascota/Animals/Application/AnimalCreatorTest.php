<?php

namespace App\Tests\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\AnimalCreator;
use App\MiMascota\Animals\Application\Command\CreateAnimalCommand;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\Tests\MiMascota\Shared\AnimalMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalCreatorTest extends TestCase
{
    private $animalCreator;
    private $animalRepository;

    protected function setUp(): void
    {

        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->animalCreator = new AnimalCreator($this->animalRepository);
    }
    public function test__invoke()
    {
        $animal = AnimalMock::generate(Uuid::uuid4()->toString());
        $this->animalRepository->expects($this->once())
            ->method('save');

$command = new CreateAnimalCommand(
            $animal->getName(),
            $animal->getDescription(),
            $animal->getColor(),
            $animal->getSize(),
            $animal->getBreed(),
            $animal->getGender(),
            $animal->getBirthDate(),
            $animal->getWeight()
);
        $newAnimal = $this->animalCreator->__invoke($command);
        $this->assertEquals($animal->getName(),$newAnimal->getName());
        $this->assertEquals($animal->getDescription(),$newAnimal->getDescription());
        $this->assertEquals($animal->getColor(),$newAnimal->getColor());
        $this->assertEquals($animal->getSize(),$newAnimal->getSize());
        $this->assertEquals($animal->getBreed(),$newAnimal->getBreed());
        $this->assertEquals($animal->getGender(),$newAnimal->getGender());
        $this->assertEquals($animal->getBirthDate(),$newAnimal->getBirthDate());
        $this->assertEquals($animal->getWeight(),$newAnimal->getWeight());




    }
}
