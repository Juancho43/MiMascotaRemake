<?php

namespace App\MiMascota\Animals\Application\DTO;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Images\Application\AnimalImageResponse;

class AnimalImagesResponse
{
    public static function generate(Animal $animal): array
    {
        return [
            'id' => $animal->getId(),
            'images' => array_map(
                fn($image) => AnimalImageResponse::generate($image),
                $animal->getImages()->toArray()
            ),
        ];
    }
}
