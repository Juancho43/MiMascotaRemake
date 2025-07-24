<?php

namespace App\MiMascota\Animals\Application\DTO;

use App\MiMascota\Animals\Domain\Animal;

class AnimalImagesResponse
{
    public static function generate(Animal $animal): array
    {
        return [
            'id' => $animal->getId(),
            'images' => $animal->getImages()->toArray()
        ];
    }
}
