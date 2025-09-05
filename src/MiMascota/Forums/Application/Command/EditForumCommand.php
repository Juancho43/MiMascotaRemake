<?php

namespace App\MiMascota\Forums\Application\Command;

class EditForumCommand
{
    public function __construct(
        public string $forumId,
        public string $name,
        public string $description,
        public string $userId
    )
    {

    }
}
