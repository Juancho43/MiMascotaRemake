<?php

namespace App\MiMascota\Posts\Application\Command;

class CreatePostCommand
{
    public function __construct(
        public string $postTitle,
        public string $postContent,
        public string $animalId,
        public string $forumSlug,
        public string $userId,
        public string $locationId
    )
    {

    }
}
