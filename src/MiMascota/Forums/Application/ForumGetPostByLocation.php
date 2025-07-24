<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class ForumGetPostByLocation
{
    public function __construct(private PostRepository $postRepository, private LocationRepository $locationRepository, private  ForumRepository $forumRepository)
    {

    }


    public function __invoke(string $forumSlug, string $locationId, int $page = 1, int $limit = 10): array
    {
        if (!$this->forumRepository->getBySlug($forumSlug)) {
            throw new ModelNotFound("forum", 'slug', $forumSlug);
        }
        if (!$this->locationRepository->search($locationId)) {
            throw new ModelNotFound("location", 'id', $locationId);
        }
        return $this->postRepository->getByForumFilterLocation($forumSlug, $locationId, $page, $limit);
    }
}
