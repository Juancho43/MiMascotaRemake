<?php

namespace App\MiMascota\Users\Domain\Exceptions;

use DomainException;

class UserPasswordIncorrect extends DomainException
{
    public function __construct()
    {
        parent::__construct('The password is incorrect.');
    }
}

