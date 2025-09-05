<?php

namespace App\MiMascota\Animals\Application\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddAnimalImageCommand
{

    public function __construct(
        public string $animalId,

        public string $temporalPath,
        public string $mimeType,
        public string $size,
        public int    $position
    )
    {

    }
}
