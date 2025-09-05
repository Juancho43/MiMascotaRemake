<?php

namespace App\MiMascota\Forums\Application\Query;

use App\MiMascota\Forums\Application\Command\AddForumImageCommand;
use App\MiMascota\Forums\Application\ForumGetById;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Forums\Domain\ValueObject\ForumImage;
use App\MiMascota\Images\Application\SaveImage;
use Ramsey\Uuid\Uuid;

final readonly class ForumAddImage
{
    public function __construct(
       private SaveImage $saveImage,
        private ForumGetById $forumGetById,
        private ForumRepository $forumRepository,
    ){}

    public function __invoke(AddForumImageCommand $command) : ForumImage
    {
        $forum = $this->forumGetById->__invoke(new GetForumByIdQuery($command->forumId));
        $image = $this->saveImage->__invoke(
            $command->imageFile,
            'forum',
            $command->forumId,
        );
        $forumImage = ForumImage::create(Uuid::uuid4()->toString(),$forum,$image);
        $forum->addImage($forumImage);
        $this->forumRepository->save($forum);
        return $forumImage;

    }
}
