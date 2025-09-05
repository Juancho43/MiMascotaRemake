<?php

namespace App\MiMascota\Images\Application;

use App\MiMascota\Images\Application\Query\GetImageByIdQuery;
use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class GetImageById
{
    public function __construct(
        private ImageRepository $repository,
    )
    {

    }

    public function __invoke(GetImageByIdQuery $query) : Image
    {
        $image = $this->repository->search($query->imageId);
        if ($image === null) {
            throw new ModelNotFound("image");
        }

        return $image;
    }
}
