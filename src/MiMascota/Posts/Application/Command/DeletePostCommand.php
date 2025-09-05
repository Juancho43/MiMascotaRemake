<?php

namespace App\MiMascota\Posts\Application\Command;

final readonly class DeletePostCommand
{
    public function __construct(
        public string $postId
    )
    {

    }
}
