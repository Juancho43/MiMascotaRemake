<?php

namespace App\MiMascota\Posts\Application;

use App\MiMascota\Posts\Application\Command\ReportPostCommand;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;

final readonly class PostReport
{

    public function __construct(
        private PostGetById $postGetById,
        private PostRepository $postRepository,
    )
    {

    }

    public function __invoke(ReportPostCommand $command) : Post
    {
        $post = $this->postGetById->__invoke(new GetPostByIdQuery($command->id));
        $post->report();
        // If the post has been reported 3 times, ban the user
        //HACER CASO DE USO PARA BANEAR AL USUARIO
        $post->getUser()->banUser();
        $this->postRepository->save($post);
        return $post;
    }
}
