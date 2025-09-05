<?php

namespace App\MiMascota\Images\Application\DTO;

use App\MiMascota\Images\Domain\Image;

final readonly class ImageResponse
{
    public static function generate(Image $image): array
    {
        return [
            'id' => $image->getId(),
            'path' => $image->getPath(),
            'type' => $image->getType(),
            'size' => $image->getSize(),
            'imageable_id' => $image->getImageableId(),
            'imageable' => $image->getImageableType(),
            'createdAt' => $image->getTimeStamp()->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $image->getTimeStamp()->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
