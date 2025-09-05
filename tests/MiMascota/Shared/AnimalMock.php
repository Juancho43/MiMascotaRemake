<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\ValueObject\AnimalBirthDate;
use App\MiMascota\Animals\Domain\ValueObject\AnimalBreed;
use App\MiMascota\Animals\Domain\ValueObject\AnimalColor;
use App\MiMascota\Animals\Domain\ValueObject\AnimalDescription;
use App\MiMascota\Animals\Domain\ValueObject\AnimalGender;
use App\MiMascota\Animals\Domain\ValueObject\AnimalName;
use App\MiMascota\Animals\Domain\ValueObject\AnimalSize;
use App\MiMascota\Animals\Domain\ValueObject\AnimalWeight;

class AnimalMock
{
    public static function generate($id,
                                    $name ='Test Animal',
                                    $description = 'This is a test animal',
                                    $color = 'Brown',
                                    $size = 'medium',
                                    $breed = 'Labrador',
                                    $gender = 'male',
                                    $birthDate = '2020-01-01',
                                    $weight = 20.0
    ) : Animal
    {
        return Animal::create(
            $id,
            AnimalName::generate($name),
            AnimalDescription::generate($description),
            AnimalColor::generate($color),
            AnimalSize::generate($size),
            AnimalBreed::generate($breed),
            AnimalGender::generate($gender),
            AnimalBirthDate::generate($birthDate),
            AnimalWeight::generate($weight)
        );
    }
}
