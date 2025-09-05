<?php

namespace App\MiMascota\Images\Application;

use App\MiMascota\Images\Application\Command\DeleteImageCommand;
use App\MiMascota\Images\Application\GetImageById;
use App\MiMascota\Images\Application\Query\GetImageByIdQuery;
use App\MiMascota\Images\Domain\IDeleteImage;
use App\MiMascota\Images\Domain\ImageRepository;

final readonly class DeleteImage
{
    public function __construct(
        private ImageRepository $repository,
        private GetImageById $getImageById,
        private IDeleteImage $deleter
    )
    {

    }

public function __invoke(DeleteImageCommand $command): void
    {
        $image = $this->getImageById->__invoke(new GetImageByIdQuery($command->imageId));
        $this->deleter->delete($image->getPath());
        $this->repository->remove($image);
    }


}
