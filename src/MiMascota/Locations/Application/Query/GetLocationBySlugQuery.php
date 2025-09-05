<?php

namespace App\MiMascota\Locations\Application\Query;

final readonly class GetLocationBySlugQuery
{
    public function __construct(
        public string $locationSlug
    )
    {

    }
}
