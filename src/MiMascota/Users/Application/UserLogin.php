<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Application\Command\LoginUserCommand;
use App\MiMascota\Users\Application\Query\GetUserByEmailQuery;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserLogin
{
    public function __construct(
        private UserRepository $repository,
        private UserGetByEmail $userGetByEmail
    )
    {

    }


    public function __invoke(LoginUserCommand $command): ?string
    {
        $user = $this->userGetByEmail->__invoke(new GetUserByEmailQuery($command->email));
        $token =  $user->loginWithDevice($command->password,$command->ip,$command->agent);
        $this->repository->save($user);
        return $token;
    }

}
