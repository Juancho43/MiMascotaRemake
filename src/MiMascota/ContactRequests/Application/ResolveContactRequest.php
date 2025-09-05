<?php

namespace App\MiMascota\ContactRequests\Application;

use App\MiMascota\ContactRequests\Application\Command\ResolveContactRequestCommand;
use App\MiMascota\ContactRequests\Application\Query\GetContactRequestByIdQuery;
use App\MiMascota\ContactRequests\Domain\ContactRequest;
use App\MiMascota\ContactRequests\Domain\ContactRequestRepository;
use App\MiMascota\ContactRequests\Domain\ContactRequestStatus;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;

final readonly class ResolveContactRequest
{
public function __construct(
    private ContactRequestRepository $repository,
    private GetContactRequestById $contactRequestById,
){}

    public function __invoke(ResolveContactRequestCommand $command): ContactRequest
    {
        $contactRequest = $this->contactRequestById->__invoke(new GetContactRequestByIdQuery($command->id));
        $contactRequest->setStatus(ContactRequestStatus::create($command->status));
        $this->repository->save($contactRequest);
        return $contactRequest;
    }
}
