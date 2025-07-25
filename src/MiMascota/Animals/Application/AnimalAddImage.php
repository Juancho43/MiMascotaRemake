<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Images\Application\ImageResponse;
use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Shared\Domain\ModelNotFound;
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
    ): array
    {
        $animal = $this->animalRepository->search($animalId);
        if ($animal === null){
            throw new ModelNotFound('animal','id',$animalId);
        }
        $image = $this->saveImage->__invoke(
            $imageFile,
            'animal',
            $animalId,
        );
        $animalImage = AnimalImage::create(Uuid::uuid4()->toString(),$animal,$image,$position);
        $animal->addImage($animalImage);
        $this->animalRepository->save($animal);
        return ImageResponse::generate($image);
    }
}
