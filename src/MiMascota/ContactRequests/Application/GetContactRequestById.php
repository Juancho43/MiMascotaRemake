<?php

namespace App\MiMascota\ContactRequests\Application;

use App\MiMascota\ContactRequests\Application\Query\GetContactRequestByIdQuery;
use App\MiMascota\ContactRequests\Domain\ContactRequest;
use App\MiMascota\ContactRequests\Domain\ContactRequestRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class GetContactRequestById
{
    public function __construct(private ContactRequestRepository $repository){}

    public function __invoke(GetContactRequestByIdQuery $query): ContactRequest
    {
        $contactRequest = $this->repository->findById($query->id);
        if ($contactRequest === null){
            throw new ModelNotFound('ContactRequest');
        }
        return $contactRequest;

    }
}
