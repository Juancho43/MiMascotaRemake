<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Users\Domain\UserRepository;

class PostEdit
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
            throw new \InvalidArgumentException('Post not found');
        }
        $user = $this->userRepository->search($userId);
        if (null === $user) {
            throw new \InvalidArgumentException('User not found');
        }
        if ($post->getUser()->getId() !== $user->getId()) {
            throw new \InvalidArgumentException('User does not have permission to edit this post');
        }
        $location = $this->locationRepository->search($locationId);
        if (null === $location) {
            throw new \InvalidArgumentException('Location not found');
        }

        $animal = $this->animalRepository->search($animalId);
        if (null === $animal) {
            throw new \InvalidArgumentException('Animal not found');
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
