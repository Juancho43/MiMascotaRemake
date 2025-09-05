<?php

namespace App\MiMascota\ContactRequests\Application\Command;

class CreateContactRequestCommand
{
    public function __construct(
        public string $id,
        public string $requesterId,
        public string $ownerId,
        public string $postId,
        public string $status
    ){}
}
