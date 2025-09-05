<?php

namespace App\MiMascota\Animals\Application\Query;

final readonly class GetAnimalByIdQuery
{
    public function __construct(
        public string $animalId
    )
    {

    }
}
