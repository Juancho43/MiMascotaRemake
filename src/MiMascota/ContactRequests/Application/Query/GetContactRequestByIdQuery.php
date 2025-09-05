<?php

namespace App\MiMascota\ContactRequests\Application\Query;

class GetContactRequestByIdQuery
{
    public function __construct(public string $id){}
}
