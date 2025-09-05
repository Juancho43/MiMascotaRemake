<?php

namespace App\MiMascota\Users\Application\Command;

final readonly class ChangeUserPasswordCommand
{
    public function __construct(
        public string $email,
        public string $newPassword
    )
    {

    }
}
