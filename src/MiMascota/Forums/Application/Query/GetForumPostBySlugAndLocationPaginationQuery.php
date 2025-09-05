<?php

namespace App\MiMascota\Forums\Application\Query;

class GetForumPostBySlugAndLocationPaginationQuery
{
    public function __construct(
        public string $slug,
        public string $locationSlug,
        public int    $page = 1,
        public int    $limit = 10
    )
    {

    }
}
