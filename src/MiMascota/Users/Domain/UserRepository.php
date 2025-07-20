<?php

namespace App\MiMascota\Users\Domain;

interface UserRepository
{
    public function search(string $id): ?User;
    public function findByMail(string $email): ?User;
    public function findByToken(string $token): ?User;

    public function save(User $user): void;

    public function remove(User $user): void;

}
