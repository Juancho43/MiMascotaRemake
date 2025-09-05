<?php

namespace App\MiMascota\Users\Application\Command;

final readonly class LogoutUserCommand
{
    public function __construct(
        public string $token,
        public string $ip,
        public string $agent
    )
    {

    }
}
