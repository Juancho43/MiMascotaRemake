<?php
namespace App\MiMascota\ContactRequests\Application;

use App\MiMascota\ContactRequests\Application\Query\GetAllContactRequestByUserQuery;
use App\MiMascota\ContactRequests\Application\Query\GetContactRequestByIdQuery;
use App\MiMascota\ContactRequests\Domain\ContactRequestRepository;

final readonly class GetAllContactRequestByRequester
{
    public function __construct(private ContactRequestRepository $repository)
    {

    }

    public function __invoke(GetAllContactRequestByUserQuery $query): array
    {
        return $this->repository->findByRequesterId($query->id);
    }
}
