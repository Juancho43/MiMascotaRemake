<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Posts\Application\Query\GetPostsByUserIdQuery;
use App\MiMascota\Posts\Domain\PostRepository;

class PostsGetAllData
{
public function __construct(private PostRepository $repository)
{
}

public function __invoke(GetPostsByUserIdQuery $query) : array
{
    return $this->repository->getByUserId($query->userId, $query->page, $query->limit);
}
}
