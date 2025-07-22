<?php

namespace App\MiMascota\Posts\Domain\Exceptions;

class PostNotFound extends \DomainException
{
    public function __construct($id)
    {
        parent::__construct(sprintf('Post with id %s not found', $id));
    }
}
