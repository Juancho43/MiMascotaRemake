<?php

namespace App\MiMascota\Users\Domain\Exceptions;

class UserNotFoundByToken extends \DomainException
{
    public function __construct(string $token)
    {
        parent::__construct(sprintf('User with token: %s not found', $token));
    }
}
