<?php

namespace App\MiMascota\Journals\Domain\Exceptions;

class JournalNotFound extends \DomainException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Journal with id %s not found', $id));
    }
}
