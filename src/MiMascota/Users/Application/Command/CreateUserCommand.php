<?php

namespace App\MiMascota\Users\Application\Command;

final readonly class CreateUserCommand
{
    public function __construct(
        public string $name,
        public string $telephone,
        public string $email,
        public string $password,
        public string $role,
        public float $latitude,
        public float $longitude
    )
    {

    }
}
