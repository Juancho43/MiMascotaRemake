<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Posts\Domain\PostRepository;
final readonly class ForumGetPosts
{

    public function __construct(private PostRepository $repository)
    {
    }

    public function __invoke(string $slug, int $page = 1, int $limit = 10): array
    {
        return $this->repository->getByForumSlug($slug, $page, $limit);
    }

}
