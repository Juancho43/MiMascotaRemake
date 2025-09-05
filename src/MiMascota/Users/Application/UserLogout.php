<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Application\Command\LogoutUserCommand;
use App\MiMascota\Users\Application\Query\GetUserByTokenQuery;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\UserTokenRepository;

final readonly class UserLogout
{
    public function __construct(
        private UserRepository $repository,
        private UserTokenRepository $tokenRepository,
        private UserGetByToken $getByToken
    )
    {
    }

    public function __invoke(LogoutUserCommand $command): bool
    {
            $user = $this->getByToken->__invoke(new GetUserByTokenQuery($command->token));
            $this->tokenRepository->remove($user->findTokenByIpAndUserAgent($command->ip, $command->agent));
            $response = $user->logoutFromDevice($command->ip,$command->agent);
            $this->repository->save($user);
            return $response;

    }


}
