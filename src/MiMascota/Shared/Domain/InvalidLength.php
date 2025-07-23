<?php

namespace App\MiMascota\Shared\Domain;

class InvalidLength extends \DomainException
{
    public function __construct($field, int $minLength, int $maxLength)
    {
        parent::__construct("The length of '{$field}' must be between {$minLength} and {$maxLength} characters.");
    }

}
