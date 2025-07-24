<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\UserRepository;
use Ramsey\Uuid\Uuid;

final readonly class PostCreator
{

    public function __construct(
        private PostRepository $repository,
        private AnimalRepository $animalRepository,
        private ForumRepository $forumRepository,
        private UserRepository $userRepository,
        private LocationRepository $locationRepository
    )
    {

    }

    public function __invoke(
        string $postTitle,
        string $postContent,
        string $animalId,
        string $forumId,
        string $userId,
        string $locationId
    ) : array
    {

            $user = $this->userRepository->search($userId);
            if ($user === null) {
                throw new ModelNotFound("user");
            }
            $location = $this->locationRepository->search($locationId);
            if ($location === null) {
                throw new ModelNotFound("location");
            }
            $animal = $this->animalRepository->search($animalId);
            if ($animal === null) {
                throw new ModelNotFound("animal");
            }
            $forum = $this->forumRepository->search($forumId);
            if ($forum === null) {
                throw new ModelNotFound("forum");
            }

            $post = Post::create(
                Uuid::uuid4()->toString(),
                $postTitle,
                SlugGenerator::generate($postTitle),
                $postContent,
                $forum,
                $user,
                $animal,
                $location
            );
            $this->repository->save($post);
            return PostResponse::generate($post);

    }
}
