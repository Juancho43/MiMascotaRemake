<?php

namespace App\MiMascota\Images\Application;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class SaveAnimalImage
{
    public function __construct(
        private SaveImage $saveImage,
    )
    {

    }

    public function __invoke(
        UploadedFile $imageFile,
        string $animalId
    ): ?string {
        return $this->saveImage->__invoke(
            $imageFile,
            'animal',
            $animalId,
        );
    }
}
