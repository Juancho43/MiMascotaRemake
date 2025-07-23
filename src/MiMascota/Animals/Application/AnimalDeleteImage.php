<?php

namespace App\MiMascota\Animals\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class AnimalDeleteImage
{
    public function __construct(
        private AnimalRepository $repository,
        private ImageRepository $imageRepository,
    ){}

    public function __invoke(string $animalId, string $imageId): bool
    {
        $animal = $this->repository->search($animalId);
        if ($animal === null) {
            throw new ModelNotFound("animal");
        }

        $image = $this->imageRepository->getFromAnimalImage($imageId, $animalId);
        if ($image === null) {
            throw new ModelNotFound("image");
        }

        $response = unlink($image->getImage()->getPath());
        $animal->removeImage($image);
        $this->repository->save($animal);
        $this->imageRepository->remove($image->getImage());
        return $response;
    }
}
