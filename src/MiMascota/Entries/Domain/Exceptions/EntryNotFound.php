<?php

namespace App\MiMascota\Entries\Domain\Exceptions;

class EntryNotFound extends \DomainException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Entry with id %s not found', $id));
    }
}
