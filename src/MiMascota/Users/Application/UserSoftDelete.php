<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserSoftDelete
{
    public function __construct(
        private UserRepository $userRepository,
        private UserGetById $userGetById
    )
    {
    }

    public function __invoke(GetUserByIdQuery $query): User
    {
        $user = $this->userGetById->__invoke($query);
        $user->getSoftDelete()->markAsDeleted();
        $user->getTimeStamp()->update();
        $this->userRepository->save($user);
        return $user;
    }

}
