<?php

namespace App\MiMascota\Users\Application\Query;

final readonly class GetUserByIdQuery
{
    public function __construct(
        public string $userId
    )
    {

    }
}
