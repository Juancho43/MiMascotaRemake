<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class PostGetById
{

    public function __construct(private PostRepository $postRepository)
    {}

    public function __invoke(GetPostByIdQuery $query): Post
    {
        $post = $this->postRepository->search($query->postId);

        if ($post === null) {
            throw new ModelNotFound("post");
        }

        return $post;

    }

}
