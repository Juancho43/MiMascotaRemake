<?php

namespace App\Tests\MiMascota\Animals\Domain\ValueObject;

use App\MiMascota\Animals\Domain\ValueObject\AnimalGender;
use http\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AnimalGenderTest extends TestCase
{


    public function testGetValues()
    {
        $animalGender = AnimalGender::getValues();
        $this->assertIsArray($animalGender);
        $this->assertContains('male', $animalGender);
        $this->assertContains('female', $animalGender);
        $this->assertContains('unknown', $animalGender);

    }

    public function testGenerateFails()
    {
        $this->expectException(\InvalidArgumentException::class);
        AnimalGender::generate('invalid value');
    }
}
