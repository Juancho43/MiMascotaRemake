<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Animals\Application\AnimalGetById;
use App\MiMascota\Animals\Application\Command\DeleteAnimalImageCommand;
use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Forums\Application\Command\DeleteForumImageCommand;
use App\MiMascota\Forums\Application\Query\GetForumByIdQuery;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Images\Application\Command\DeleteImageCommand;
use App\MiMascota\Images\Application\DeleteImage;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class ForumDeleteImage
{
    public function __construct(
        private ForumRepository $repository,
        private ForumGetById $animalGetById,
        private ImageRepository $imageRepository,
        private DeleteImage $deleteImage
    ){}

    public function __invoke(DeleteForumImageCommand $command) : void
    {
        $forum = $this->animalGetById->__invoke(new GetForumByIdQuery($command->forumId));

        $image = $this->imageRepository->getFromForumImage($command->forumId);
            if ($image === null) {
            throw new ModelNotFound("image");
        }
        $forum->deleteImage();
        $this->repository->save($forum);
        $this->deleteImage->__invoke(new DeleteImageCommand($image->getImage()->getId()));
    }
}
