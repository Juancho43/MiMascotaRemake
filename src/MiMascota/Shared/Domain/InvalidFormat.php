<?php

namespace App\MiMascota\Shared\Domain;

class InvalidFormat extends \DomainException
{
    public function __construct(string $value, string $format)
    {
        parent::__construct("The value '{$value}' does not match the required format: {$format}.");
    }
}
