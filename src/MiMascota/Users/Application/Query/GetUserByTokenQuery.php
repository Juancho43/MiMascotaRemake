<?php

namespace App\MiMascota\Users\Application\Query;

final readonly class GetUserByTokenQuery
{
    public function __construct(
        public string $userToken
    )
    {

    }
}
