<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Application\Command\DeleteAnimalImageCommand;
use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Images\Application\Command\DeleteImageCommand;
use App\MiMascota\Images\Application\DeleteImage;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class AnimalDeleteImage
{
    public function __construct(
        private AnimalRepository $repository,
        private AnimalGetById $animalGetById,
        private ImageRepository $imageRepository,
        private DeleteImage $deleteImage
    ){}

    public function __invoke(DeleteAnimalImageCommand $command) : void
    {
        $animal = $this->animalGetById->__invoke(new GetAnimalByIdQuery($command->animalId));

        $image = $this->imageRepository->getFromAnimalImage($command->imageId, $command->animalId);
        if ($image === null) {
            throw new ModelNotFound("image");
        }
        $animal->removeImage($image);
        $this->repository->save($animal);
        $this->deleteImage->__invoke(new DeleteImageCommand($command->imageId));
    }
}
