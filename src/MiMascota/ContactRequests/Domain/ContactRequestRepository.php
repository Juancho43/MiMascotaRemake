<?php

namespace App\MiMascota\ContactRequests\Domain;

interface ContactRequestRepository
{
    public function save(ContactRequest $contactRequest): void;
    public function findById(string $id): ?ContactRequest;

    public function findByRequesterId(string $id) : array;
    public function findByOwnerId(string $id) : array;

}
