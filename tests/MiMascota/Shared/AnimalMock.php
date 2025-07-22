<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Animals\Domain\Animal;

class AnimalMock
{
    public static function generate($id,
                                    $name ='Test Animal',
                                    $description = 'This is a test, animal',
                                    $color = 'Brown',
                                    $size = 'Medium',
                                    $breed = 'Labrador',
                                    $gender = 'Male',
                                    $birthDate = '2020-01-01',
                                    $weight = 20.0
    ) : Animal
    {
        return Animal::create(
            $id,
            $name,
            $description,
            $color,
            $size,
            $breed,
            $gender,
            new \DateTimeImmutable($birthDate),
            $weight
        );
    }
}
