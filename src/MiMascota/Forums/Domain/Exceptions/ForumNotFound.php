<?php

namespace App\MiMascota\Forums\Domain\Exceptions;

class ForumNotFound extends \DomainException
{
    public function __construct($id)
    {
        parent::__construct(sprintf('Forum with id %s not found', $id));
    }

}
