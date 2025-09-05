<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\Query\GetUserByEmailQuery;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserGetByEmail
{
    public function __construct(
        private UserRepository $repository,
    )
    {

    }

    public function __invoke(GetUserByEmailQuery $query): User
    {
        $user = $this->repository->findByMail($query->userEmail);

        if ($user === null) {
            throw new ModelNotFound("User", 'email', $query->userEmail);
        }

        return $user;
    }
}
