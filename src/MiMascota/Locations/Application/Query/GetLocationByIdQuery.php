<?php

namespace App\MiMascota\Locations\Application\Query;

final readonly class GetLocationByIdQuery
{
    public function __construct(
        public string $locationId
    )
    {

    }
}
