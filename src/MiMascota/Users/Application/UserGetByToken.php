<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\Query\GetUserByTokenQuery;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserGetByToken
{
    public function __construct(
        private UserRepository $repository,
    )
    {

    }

    public function __invoke(GetUserByTokenQuery $query): User
    {
        $user = $this->repository->findByToken($query->userToken);

        if ($user === null) {
            throw new ModelNotFound("User", 'token', $query->userToken);
        }

        return $user;
    }
}
