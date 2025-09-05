<?php

namespace App\MiMascota\ContactRequests\Application\Query;

class GetAllContactRequestByUserQuery
{

    /**
     * @param string $id
     */
    public function __construct(public string $id)
    {
    }
}
