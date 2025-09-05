<?php

namespace App\MiMascota\Animals\Application\Command;

class DeleteAnimalImageCommand
{
    public function __construct(
        public string $animalId,
        public string $imageId
    )
    {

    }
}
