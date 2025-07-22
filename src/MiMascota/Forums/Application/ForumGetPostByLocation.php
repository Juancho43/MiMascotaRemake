<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Domain\PostRepository;

class ForumGetPostByLocation
{
    public function __construct(private PostRepository $postRepository, private LocationRepository $locationRepository, private  ForumRepository $forumRepository)
    {

    }

    public function __invoke(string $forumSlug, string $locationId, int $page = 1, int $limit = 10): array
    {
        if (!$this->forumRepository->getBySlug($forumSlug)) {
            throw new \InvalidArgumentException("Forum with slug '$forumSlug' not found.");
        }
        if (!$this->locationRepository->search($locationId)) {
            throw new \InvalidArgumentException("Location with ID '$locationId' not found.");
        }
        return $this->postRepository->getByForumFilterLocation($forumSlug, $locationId, $page, $limit);
    }
}
