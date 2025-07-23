<?php

namespace App\MiMascota\Animals\Domain\Exceptions;

class AnimalNotFoundByJournalId extends \DomainException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Animal with Journal id %s not found', $id));
    }
}
