<?php

namespace App\MiMascota\Posts\Application\Query;

final readonly class GetPostByIdQuery
{
    public function __construct(
        public string $postId
    )
    {

    }
}
