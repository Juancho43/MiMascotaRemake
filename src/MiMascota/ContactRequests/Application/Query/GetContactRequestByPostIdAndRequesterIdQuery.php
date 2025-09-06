<?php

namespace App\MiMascota\ContactRequests\Application\Query;

class GetContactRequestByPostIdAndRequesterIdQuery
{
    public function __construct(
        public string $postId,
        public string $requesterId
    )
    {

    }
}
