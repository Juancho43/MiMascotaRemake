<?php

namespace App\MiMascota\Animals\Domain\Exceptions;

class AnimalNotFound extends \DomainException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Animal with id %s not found', $id));
    }
}
