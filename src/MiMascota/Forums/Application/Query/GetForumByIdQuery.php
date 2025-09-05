<?php

namespace App\MiMascota\Forums\Application\Query;

final readonly class GetForumByIdQuery
{
    public function __construct(
        public string $forumId
    )
    {

    }
}
