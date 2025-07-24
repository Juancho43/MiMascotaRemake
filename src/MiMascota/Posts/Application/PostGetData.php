<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class PostGetData
{

    public function __construct(private PostRepository $postRepository)
    {}

    public function __invoke(string $id): array
    {
        $post = $this->postRepository->search($id);

        if ($post === null) {
            throw new ModelNotFound("post");
        }

        return PostResponse::generate($post);
    }

}
