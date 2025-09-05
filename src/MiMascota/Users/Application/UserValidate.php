<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Application\Command\ValidateUserCommand;
use App\MiMascota\Users\Application\Query\GetUserByEmailQuery;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserValidate
{
    public function __construct(
        private UserRepository $repository,
        private UserGetByEmail $userGetByEmail
    )
    {
    }

    public function __invoke(ValidateUserCommand $command): string
    {
        $user = $this->userGetByEmail->__invoke(new GetUserByEmailQuery($command->email));
        $token = $user->verifyCodeAndLoginWithDevice($command->code,$command->ip,$command->agent);
        $user->getTimeStamp()->update();
        $this->repository->save($user);
        return $token;
    }

}
