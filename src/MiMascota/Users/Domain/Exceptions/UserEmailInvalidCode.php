<?php

namespace App\MiMascota\Users\Domain\Exceptions;

class UserEmailInvalidCode extends \DomainException
{
    public function __construct(string $email){
        parent::__construct("The verification code for the email '{$email}' is invalid or has already been used.");
    }
}
