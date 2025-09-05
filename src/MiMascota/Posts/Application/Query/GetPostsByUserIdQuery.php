<?php

namespace App\MiMascota\Posts\Application\Query;

class GetPostsByUserIdQuery
{
    public function __construct(
        public string $userId,
        public int $page = 1,
        public int $limit = 10
    )
    {

    }
}
