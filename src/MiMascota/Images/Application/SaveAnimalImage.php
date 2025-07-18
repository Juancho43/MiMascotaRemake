<?php

namespace App\MiMascota\Images\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Images\Domain\AnimalImage;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SaveAnimalImage
{
    public function __construct(
        private readonly SaveImage $saveImage,
        private readonly AnimalRepository $animalRepository,
    )
    {

    }

    public function __invoke(
        UploadedFile $imageFile,
        string $animalId,
        int $position
    ): ?string {
        $animal = $this->animalRepository->search($animalId);
        $image = $this->saveImage->__invoke(
            $imageFile,
            'animal',
            $animalId,
        );
        $animalImage = AnimalImage::create(Uuid::uuid4()->toString(),$animal,$image,$position);
        $animal->addImage($animalImage);
        $this->animalRepository->save($animal);
        return $image->getPath();
    }
}
