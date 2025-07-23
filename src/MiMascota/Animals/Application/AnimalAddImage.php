<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Animals\Domain\Exceptions\AnimalNotFound;
use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\AnimalImage;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class AnimalAddImage
{
    public function __construct(
        private SaveImage $saveImage,
        private AnimalRepository $animalRepository,
    )
    {

    }

    public function __invoke(
        UploadedFile $imageFile,
        string $animalId,
        int $position
    ): ?string {
        $animal = $this->animalRepository->search($animalId);
        if ($animal === null){
            throw new AnimalNotFound($animalId);
        }
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
