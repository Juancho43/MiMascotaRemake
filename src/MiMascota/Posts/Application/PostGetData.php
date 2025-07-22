<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Domain\PostRepository;

class PostGetData
{

    public function __construct(private PostRepository $postRepository)
    {}

    public function __invoke(string $id): array
    {
        $post = $this->postRepository->search($id);

        if (!$post) {
            throw new \Exception("Post not found");
        }

        return PostResponse::generate($post);
    }

}
