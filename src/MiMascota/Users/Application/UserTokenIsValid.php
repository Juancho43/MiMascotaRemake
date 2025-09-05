<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Application\Command\UserIsAdminCommand;
use App\MiMascota\Users\Application\Query\GetUserByTokenQuery;

final readonly class UserTokenIsValid
{
    public function __construct(private UserGetByToken $getByToken)
    {

    }

    public function __invoke(UserIsAdminCommand $command ): bool
    {
        $user = $this->getByToken->__invoke(new GetUserByTokenQuery($command->token));

        $userToken = $user->getTokenByTokenValue($command->token);
        if (!$userToken) {
            return false;
        }

        try {
            $userToken->checkExpired();
        } catch (\Exception) {
            return false;
        }

        return true;
    }

}
