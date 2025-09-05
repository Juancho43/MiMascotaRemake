<?php

namespace App\MiMascota\Forums\Application\Query;

class GetForumPostBySlugPaginationQuery
{
    public function __construct(
        public string $slug,
        public int $page = 1,
        public int $limit = 10
    )
    {

    }
}
