<?php

namespace App\MiMascota\ContactRequests\Application;

use App\MiMascota\ContactRequests\Application\Query\GetAllContactRequestByUserQuery;
use App\MiMascota\ContactRequests\Domain\ContactRequestRepository;

final readonly class GetAllContactRequestByOwner
{
    public function __construct(private ContactRequestRepository $repository)
    {

    }

    public function __invoke(GetAllContactRequestByUserQuery $query): array
    {
        return $this->repository->findByOwnerId($query->id);
    }
}

