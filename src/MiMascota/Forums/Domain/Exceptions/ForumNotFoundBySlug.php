<?php

namespace App\MiMascota\Forums\Domain\Exceptions;

class ForumNotFoundBySlug extends \DomainException
{
    public function __construct($slug)
    {
        parent::__construct(sprintf('Forum with slug: %s not found', $slug));
    }

}
