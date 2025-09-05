<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\Command\ChangeUserPasswordCommand;
use App\MiMascota\Users\Application\Query\GetUserByEmailQuery;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;

final readonly class UserChangePassword
{

    public function __construct(
        private UserRepository $repository,
        private UserGetByEmail $getByEmail,
    )
    {
    }

    public function __invoke(ChangeUserPasswordCommand $command): bool
    {
        $user = $this->getByEmail->__invoke(new GetUserByEmailQuery($command->email));
        $response = $user->changePassword(UserPassword::create($command->newPassword));
        $user->getTimeStamp()->update();
        $this->repository->save($user);
        return $response;
    }
}
