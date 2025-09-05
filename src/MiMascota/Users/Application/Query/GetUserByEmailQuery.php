<?php

namespace App\MiMascota\Users\Application\Query;

final readonly class GetUserByEmailQuery
{
    public function __construct(
        public string $userEmail
    )
    {

    }
}
