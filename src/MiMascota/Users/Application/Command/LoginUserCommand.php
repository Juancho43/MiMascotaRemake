<?php

namespace App\MiMascota\Users\Application\Command;

final readonly class LoginUserCommand
{
    public function __construct(
        public string $email,
        public string $password,
        public string $ip,
        public string $agent
    )
    {

    }
}
