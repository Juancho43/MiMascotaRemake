<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\UserRepository;
use Ramsey\Uuid\Uuid;

class PostCreator
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
        try {
            $user = $this->userRepository->search($userId);
            if ($user === null) {
                throw new \Exception("User not found");
            }
            $location = $this->locationRepository->search($locationId);
            if ($location === null) {
                throw new \Exception("Location not found");
            }
            $animal = $this->animalRepository->search($animalId);
            if ($animal === null) {
                throw new \Exception("Animal not found");
            }
            $forum = $this->forumRepository->search($forumId);
            if ($forum === null) {
                throw new \Exception("Forum not found");
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
        } catch (\Exception $exception) {
            throw new \Exception("Error creating post: " . $exception->getMessage());
        }
    }
}
