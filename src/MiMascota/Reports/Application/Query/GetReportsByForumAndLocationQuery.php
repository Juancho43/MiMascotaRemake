<?php

namespace App\MiMascota\Reports\Application\Query;

class GetReportsByForumAndLocationQuery
{
    public function __construct(
        public string $forumSlug,
        public string $locationSlug,
        public int $page = 1,
        public int $limit = 10
    )
    {

    }
}
