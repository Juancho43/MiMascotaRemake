<?php

namespace App\MiMascota\ContactRequests\Domain;

use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\User;

class ContactRequest
{
    private Timestamp $timeStamp;
    private function __construct(
        private string $id,
        private User $requester,
        private User $owner,
        private Post $post,
        private ContactRequestStatus $status,
    ) {
        $this->timeStamp = new TimeStamp();
    }

    public static function create(string $id, User $requester, User $owner, Post $post, ContactRequestStatus $status): self
    {
        return new self($id, $requester, $owner, $post, $status);
    }


    public function getTimeStamp(): TimeStamp
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(TimeStamp $timeStamp): void
    {
        $this->timeStamp = $timeStamp;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getRequester(): User
    {
        return $this->requester;
    }

    public function setRequester(User $requester): void
    {
        $this->requester = $requester;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    public function getStatus(): ContactRequestStatus
    {
        return $this->status;
    }

    public function setStatus(ContactRequestStatus $status): void
    {
        $this->status = $status;
    }


}
