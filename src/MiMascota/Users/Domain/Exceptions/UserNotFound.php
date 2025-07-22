<?php

namespace App\MiMascota\Users\Domain\Exceptions;

class UserNotFound extends \DomainException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('User with id %s not found', $id));
    }
}
