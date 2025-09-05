<?php

namespace App\MiMascota\ContactRequests\Application\Command;

class ResolveContactRequestCommand
{
    public function __construct(
        public string $id,
        public string $status
    ){}
}
