<?php

namespace App\MiMascota\Images\Application\DTO;

use App\MiMascota\Images\Application\DTO\ImageResponse;
use App\MiMascota\Images\Domain\AnimalImage;

class AnimalImageResponse
{
    public static function generate(AnimalImage $animalImage) : array
    {
        return [
            'id' => $animalImage->getId(),
            'image' => ImageResponse::generate($animalImage->getImage()),
        ];
    }
}
