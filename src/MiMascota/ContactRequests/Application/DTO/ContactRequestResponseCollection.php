<?php

namespace App\MiMascota\ContactRequests\Application\DTO;

class ContactRequestResponseCollection
{
    public static function generate(array $requests) : array
    {

        $response = [];
        foreach ($requests as $request) {
            $response[] = ContactRequestResponse::generate($request);
        }
        return $response;
    }
}
