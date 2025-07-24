<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class PostSoftDelete
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    public function __invoke(string $postId): Post
    {
        $post = $this->postRepository->search($postId);
        if ($post === null) {
            throw new ModelNotFound("post");
        }

        $post->getSoftDelete()->markAsDeleted();
        $this->postRepository->save($post);
        return $post;
    }


}
