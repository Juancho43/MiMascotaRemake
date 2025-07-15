<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;

class UserChangePassword
{

    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $userId, string $newPassword): void
    {
        $user = $this->repository->search($userId);
        if ($user === null) {
            throw new \Exception("User not found");
        }

        $user->changePassword($newPassword);
        $this->repository->save($user);
    }
}
