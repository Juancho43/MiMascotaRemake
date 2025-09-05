<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\Query\GetForumPostBySlugAndLocationPaginationQuery;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Application\LocationGetById;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class ForumGetPostByLocation
{
    public function __construct(
        private PostRepository $postRepository,
    )
    {

    }


    public function __invoke(GetForumPostBySlugAndLocationPaginationQuery $query): array
    {
        return $this->postRepository->getByForumFilterLocation($query->slug, $query->locationSlug, $query->page, $query->limit);
    }
}
