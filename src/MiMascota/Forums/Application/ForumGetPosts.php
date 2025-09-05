<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\Query\GetForumPostBySlugPaginationQuery;
use App\MiMascota\Posts\Domain\PostRepository;
final readonly class ForumGetPosts
{

    public function __construct(private PostRepository $repository)
    {
    }

    public function __invoke(GetForumPostBySlugPaginationQuery $query): array
    {
        return $this->repository->getByForumSlug($query->slug, $query->page, $query->limit);
    }

}
