<?php
namespace App\MiMascota\Animals\Application\DTO;

use App\MiMascota\Animals\Domain\Animal;
use DateTime;

class AnimalResponse
{
    public static function generate(Animal $animal): array
    {
        return [
            'id' => $animal->getId(),
            'name' => $animal->getName(),
            'description' => $animal->getDescription(),
            'breed' => $animal->getBreed(),
            'birthdate' => $animal->getBirthDate() ? $animal->getBirthDate()->format('Y-m-d') : null,
            'color' => $animal->getColor(),
            'size' => $animal->getSize(),
            'weight' => $animal->getWeight(),
            'gender' => $animal->getGender(),

        ];
    }
}
