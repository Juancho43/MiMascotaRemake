<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Animals\Application\AnimalGetById;
use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Forums\Application\ForumGetBySlug;
use App\MiMascota\Forums\Application\Query\GetForumBySlugQuery;
use App\MiMascota\Locations\Application\LocationGetById;
use App\MiMascota\Locations\Application\Query\GetLocationByIdQuery;
use App\MiMascota\Locations\Application\Query\GetLocationBySlugQuery;
use App\MiMascota\Posts\Application\Command\CreatePostCommand;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Posts\Domain\ValueObject\PostContent;
use App\MiMascota\Posts\Domain\ValueObject\PostSlug;
use App\MiMascota\Posts\Domain\ValueObject\PostTitle;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use Ramsey\Uuid\Uuid;

final readonly class PostCreator
{

    public function __construct(
        private PostRepository $repository,
        private UserGetById $userGetById,
        private ForumGetBySlug $forumGetBySlug,
        private AnimalGetById $animalGetById,
        private LocationGetById $locationGetById,
    )
    {

    }

    public function __invoke(CreatePostCommand $command) : Post
    {
            $post = Post::create(
                Uuid::uuid4()->toString(),
                PostTitle::create($command->postTitle),
                PostSlug::create(SlugGenerator::generate($command->postTitle)),
                PostContent::create($command->postContent),
                $this->forumGetBySlug->__invoke(new GetForumBySlugQuery($command->forumSlug)),
                $this->userGetById->__invoke(new GetUserByIdQuery($command->userId)),
                $this->animalGetById->__invoke(new GetAnimalByIdQuery($command->animalId)),
                $this->locationGetById->__invoke(new GetLocationByIdQuery($command->locationId))
            );
            $this->repository->save($post);
            return $post;

    }
}
