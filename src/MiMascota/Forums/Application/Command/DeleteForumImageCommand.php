<?php

namespace App\MiMascota\Forums\Application\Command;

class DeleteForumImageCommand
{
    public function __construct(
        public string $forumId,
    )
    {

    }
}
