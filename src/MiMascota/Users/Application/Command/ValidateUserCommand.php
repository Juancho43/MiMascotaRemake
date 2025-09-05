<?php

namespace App\MiMascota\Users\Application\Command;

final readonly class ValidateUserCommand
{
    public function __construct(
        public string $email,
        public string $code,
        public string $ip,
        public string $agent
    )
    {

    }
}
