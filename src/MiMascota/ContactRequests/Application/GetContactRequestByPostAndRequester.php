<?php

namespace App\MiMascota\ContactRequests\Application;

use App\MiMascota\ContactRequests\Application\Query\GetContactRequestByPostIdAndRequesterIdQuery;
use App\MiMascota\ContactRequests\Domain\ContactRequest;
use App\MiMascota\ContactRequests\Domain\ContactRequestRepository;

final readonly class GetContactRequestByPostAndRequester
{
    public function __construct(private ContactRequestRepository $repository)
    {

    }

    public function __invoke(GetContactRequestByPostIdAndRequesterIdQuery $query) : ?ContactRequest
    {
        return $this->repository->findByPostIdAndRequestedId($query->postId, $query->requesterId);
    }
}
