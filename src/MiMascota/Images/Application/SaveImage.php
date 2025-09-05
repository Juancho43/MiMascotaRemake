<?php

namespace App\MiMascota\Images\Application;

use App\MiMascota\Images\Application\Command\SaveImageCommand;
use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageRepository;
use Ramsey\Uuid\Nonstandard\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class SaveImage
{
    public function __construct(
        private ImageRepository $imageRepository,
        private StoreImage $storeImage,
    ){}
    public function __invoke(SaveImageCommand $command): ?Image
    {
        $name = (new \DateTime())->getTimestamp();
        $path = 'images/' . $command->imageableType . '/' . $command->imageableId . '/' . $name;
        $image = Image::create(
            id: Uuid::uuid4()->toString(),
            name: $name,
            path: $path,
            type: $command->mimeType,
            size: $command->size,
            imageableType: $command->imageableType,
            imageableId: $command->imageableId,
        );
        if($this->storeImage->store($command->temporalPath,$path))
        {
            $this->imageRepository->save($image);
            return $image;
        }
        return null;
    }
}
