<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Posts\Application\Command\DeletePostCommand;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class PostSoftDelete
{
    public function __construct(private PostRepository $postRepository, private PostGetById $getPost)
    {
    }

    public function __invoke(DeletePostCommand $command): Post
    {
        $post = $this->getPost->__invoke(new GetPostByIdQuery($command->postId));
        $post->getSoftDelete()->markAsDeleted();
        $post->getTimeStamp()->update();
        $this->postRepository->save($post);
        return $post;
    }


}
