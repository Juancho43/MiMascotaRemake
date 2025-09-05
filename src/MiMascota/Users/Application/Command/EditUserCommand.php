<?php

namespace App\MiMascota\Users\Application\Command;

final readonly class EditUserCommand
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $telephone,
        public string $rol,
        public string $latitude,
        public string $longitude,
    ) {
    }

}
