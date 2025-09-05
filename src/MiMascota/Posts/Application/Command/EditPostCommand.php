<?php

namespace App\MiMascota\Posts\Application\Command;

class EditPostCommand
{
    public function __construct(
        public string $postId,
        public string $title,
        public string $content,
        public string $userId,
        public string $locationId,
    )
    {

    }
}
