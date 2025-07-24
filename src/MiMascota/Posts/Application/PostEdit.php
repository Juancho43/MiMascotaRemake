<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class PostEdit
{

    public function __construct(
        private PostRepository $postRepository,
        private LocationRepository $locationRepository,
        private AnimalRepository $animalRepository,
        private UserRepository $userRepository
    )
    {
    }

    public function __invoke(string $postId, string $title, string $content, string $locationId, string $animalId, string $userId): array
    {
        $post = $this->postRepository->search($postId);

        if (null === $post) {
            throw new ModelNotFound('post');
        }
        $user = $this->userRepository->search($userId);
        if (null === $user) {
            throw new ModelNotFound('user');
        }
        if ($post->getUser()->getId() !== $user->getId()) {
            throw new UserPermissionDenied('edit this post');
        }
        $location = $this->locationRepository->search($locationId);
        if (null === $location) {
            throw new ModelNotFound('location');
        }

        $animal = $this->animalRepository->search($animalId);
        if (null === $animal) {
            throw new ModelNotFound('animal');
        }

        // Update post properties
        $post->setTitle($title);
        $post->setContent($content);
        $post->setLocation($location);
        $post->setAnimal($animal);
        $post->setUser($user);

        // Save updated post
        $this->postRepository->save($post);

        return PostResponse::generate($post);
    }

}
