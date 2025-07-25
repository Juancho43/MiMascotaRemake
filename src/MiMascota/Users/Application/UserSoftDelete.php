<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserSoftDelete
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke($userId): void
    {
        $user = $this->userRepository->search($userId);
        if (null === $user) {
            throw new ModelNotFound('user');
        }

        $user->getSoftDelete()->markAsDeleted();
        $this->userRepository->save($user);
    }

}
