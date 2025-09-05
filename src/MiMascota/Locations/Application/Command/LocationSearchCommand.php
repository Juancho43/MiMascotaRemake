<?php

namespace App\MiMascota\Locations\Application\Command;

class LocationSearchCommand
{
    public function __construct(
        public string $search,
    ) {}
}
