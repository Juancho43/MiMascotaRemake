<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Animals\Application\AnimalGetById;
use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Locations\Application\LocationGetById;
use App\MiMascota\Locations\Application\Query\GetLocationByIdQuery;
use App\MiMascota\Locations\Application\Query\GetLocationBySlugQuery;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\Command\EditPostCommand;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Posts\Domain\ValueObject\PostContent;
use App\MiMascota\Posts\Domain\ValueObject\PostSlug;
use App\MiMascota\Posts\Domain\ValueObject\PostTitle;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class PostEdit
{

    public function __construct(
        private PostRepository $postRepository,
        private PostGetById $postGetById,
        private LocationGetById $locationGetById,
    )
    {
    }

    public function __invoke(EditPostCommand $command): Post
    {
        $post = $this->postGetById->__invoke(new GetPostByIdQuery($command->postId));
        $location = $this->locationGetById->__invoke(new GetLocationByIdQuery($command->locationId));

        $post->setTitle(PostTitle::create($command->title));
        $post->setSlug(PostSlug::create(SlugGenerator::generate($command->title)));
        $post->setContent(PostContent::create($command->content));
        $post->setLocation($location);
        $post->getTimeStamp()->update();
        $this->postRepository->save($post);
        return $post;
    }

}
