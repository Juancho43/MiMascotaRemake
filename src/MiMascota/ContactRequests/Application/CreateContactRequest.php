<?php

namespace App\MiMascota\ContactRequests\Application;

use App\MiMascota\ContactRequests\Application\Command\CreateContactRequestCommand;
use App\MiMascota\ContactRequests\Application\Query\GetContactRequestByPostIdAndRequesterIdQuery;
use App\MiMascota\ContactRequests\Domain\ContactRequest;
use App\MiMascota\ContactRequests\Domain\ContactRequestRepository;
use App\MiMascota\ContactRequests\Domain\ContactRequestStatus;
use App\MiMascota\Posts\Application\PostGetById;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;

final readonly class CreateContactRequest
{
    public function __construct(
        private ContactRequestRepository $repository,
        private UserGetById $userRepository,
        private PostGetById $postRepository,
        private GetContactRequestByPostAndRequester $checkExistingContactRequest

    ) {}


    public function __invoke(CreateContactRequestCommand $command): ContactRequest
    {
        {
            if ($this->checkExistingContactRequest->__invoke(new GetContactRequestByPostIdAndRequesterIdQuery($command->postId, $command->requesterId)) !== null) {
                throw new \DomainException('Contact request already exists for this post and requester');
            }
            $contactRequest = ContactRequest::create(
                $command->id,
                $this->userRepository->__invoke(new GetUserByIdQuery($command->requesterId)),
                $this->userRepository->__invoke(new GetUserByIdQuery($command->ownerId)),
                $this->postRepository->__invoke(new GetPostByIdQuery($command->postId)),
                ContactRequestStatus::create($command->status),
            );

            $this->repository->save($contactRequest);
            return $contactRequest;
        }
    }
}
