<?php

namespace App\MiMascota\Animals\Application\DTO;

use App\MiMascota\Animals\Domain\Animal;

class AnimalShortResponse
{
    public static function generate(Animal $animal) : array
    {
        return [
            'id' => $animal->getId(),
            'name' => $animal->getName(),
            'description' => $animal->getDescription(),
          'path' => $animal->getImages()->first() ? $animal->getImages()->first()->getImage()->getPath() : null
        ];
    }
}
