<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\Command\AddAnimalImageCommand;
use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Images\Application\Command\SaveImageCommand;
use App\MiMascota\Images\Application\DTO\ImageResponse;
use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Shared\Domain\ModelNotFound;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class AnimalAddImage
{
    public function __construct(
        private SaveImage $saveImage,
        private AnimalGetById $animalGetById,
        private AnimalRepository $animalRepository,
    )
    {

    }

    public function __invoke(AddAnimalImageCommand $command): AnimalImage
    {
        $animal = $this->animalGetById->__invoke(new GetAnimalByIdQuery($command->animalId));
        $saveImageCommand = new SaveImageCommand(
            $command->temporalPath,
            $command->mimeType,
            $command->size,
           'animal',
            $animal->getId()
        );
        $image = $this->saveImage->__invoke($saveImageCommand);
        $animalImage = AnimalImage::create(Uuid::uuid4()->toString(),$animal,$image,$command->position);
        $animal->addImage($animalImage);
        $this->animalRepository->save($animal);
        return $animalImage;
    }
}
