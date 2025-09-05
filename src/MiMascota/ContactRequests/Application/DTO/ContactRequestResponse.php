<?php

namespace App\MiMascota\ContactRequests\Application\DTO;

use App\MiMascota\ContactRequests\Domain\ContactRequest;

class ContactRequestResponse
{
    public static function generate(ContactRequest $request) : array
    {
        return [
            'id' => $request->getId(),
            'requester' => [
                'id' => $request->getRequester()->getId(),
                'name' => $request->getRequester()->getName(),

            ],
            'owner' => [
                'id' => $request->getOwner()->getId(),
                'name' => $request->getOwner()->getName(),
                'telephone' => ($request->getStatus()->getStatus() === 'Accepted') ?  $request->getOwner()->getTelephone() : null,
            ],
            'post' => [
                'id' => $request->getPost()->getId(),
                'title' => $request->getPost()->getTitle(),
                'animal' => $request->getPost()->getAnimal()->getName(),
            ],
            'status' => $request->getStatus()->getStatus(),
            'createdAt' => $request->getTimeStamp()?->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $request->getTimeStamp()?->getUpdatedAt()?->format('Y-m-d H:i:s')
        ];
    }
}
