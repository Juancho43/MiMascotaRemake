<?php

namespace App\MiMascota\Users\Domain\Exceptions;

use DomainException;

class UserPermissionDenied extends DomainException
{
    public function __construct($action = 'perform this action')
    {
        parent::__construct(sprintf('You do not have permission to %s.', $action));
    }
}
