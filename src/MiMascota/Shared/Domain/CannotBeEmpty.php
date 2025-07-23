<?php

namespace App\MiMascota\Shared\Domain;

class CannotBeEmpty extends \DomainException
{
    public function __construct(string $fieldName)
    {
        parent::__construct("The field '{$fieldName}' cannot be empty.");
    }
}
