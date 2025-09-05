<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Application\Command\UserIsAdminCommand;
use App\MiMascota\Users\Application\Query\GetUserByTokenQuery;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserRole;

final readonly class UserIsAdminByTokenSession
{
    public function __construct(private UserGetByToken $getByToken)
    {

    }

    public function __invoke(UserIsAdminCommand $command) : bool
    {
        $user = $this->getByToken->__invoke(new GetUserByTokenQuery($command->token));

        $userToken = $user->getTokenByTokenValue($command->token);
        if (!$userToken) {
        return false;
    }
        if ($userToken->getUserAgent() !== $command->agent) {
            return false;
        }
        if ($userToken->getIpAddress() !== $command->ip) {
            return false;
        }


        return $user->getRole()->getRole() === UserRole::ADMIN;

    }

}
