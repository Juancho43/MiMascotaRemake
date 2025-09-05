<?php

namespace App\MiMascota\Locations\Application\Query;

class GetLocationPaginatedDataQuery
{
    public function __construct(
        public int $page = 1,
        public int $limit = 10
    )
    {

    }
}
