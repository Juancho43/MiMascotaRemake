<?php

namespace App\MiMascota\Images\Application;

use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageRepository;
use Ramsey\Uuid\Nonstandard\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class SaveImage
{

    public function __construct(
        private ImageRepository $imageRepository,
    )
    {
        // Constructor logic if needed
    }

     public function __invoke(
        UploadedFile $file,
         string $imageableType,
         string $imageableId,
    ): ?Image
    {
        $name= (new \DateTime())->getTimestamp();
        $path = 'images/' . $imageableType . '/' . $imageableId . '/' . $name;
        $image = Image::create(
            id: Uuid::uuid4()->toString(),
            name: $name,
            path: $path,
            type: $file->getClientMimeType(),
            size: $file->getSize(),
            imageableType: $imageableType,
            imageableId: $imageableId,
     );
     // Create directory structure
     $dirPath = dirname($path);
     if (!file_exists($dirPath)) {
         mkdir($dirPath, 0755, true);
     }
     // Move the uploaded file

     if ($file->move($dirPath, $name)) {
         $this->imageRepository->save($image);
         return $image;
     }
        return null;
    }
}
