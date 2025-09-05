<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserGetById
{
    public function __construct(
        private UserRepository $repository,
    )
    {

    }

    public function __invoke(GetUserByIdQuery $query): User
    {
        $user = $this->repository->search($query->userId);

        if ($user === null) {
            throw new ModelNotFound("User", 'id', $query->userId);
        }

        return $user;
    }
}
