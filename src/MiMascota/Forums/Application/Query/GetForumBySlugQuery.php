<?php

namespace App\MiMascota\Forums\Application\Query;

final readonly class GetForumBySlugQuery
{
    public function __construct(
        public string $forumSlug
    )
    {

    }
}
