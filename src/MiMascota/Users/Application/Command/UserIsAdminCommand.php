<?php

namespace App\MiMascota\Users\Application\Command;

final readonly class UserIsAdminCommand
{
    public function __construct(
        public string $ip,
        public string $agent,
        public string $token,
    )
    {

    }
}
