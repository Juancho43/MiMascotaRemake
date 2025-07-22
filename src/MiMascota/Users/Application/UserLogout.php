<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\UserTokenRepository;

class UserLogout
{
    public function __construct(
        private UserRepository $repository,
        private UserTokenRepository $tokenRepository
    )
    {
    }

    public function __invoke(string $token,string $ip, string $agent): bool
    {
        try {
            $user = $this->repository->findByToken($token);

            if ($user === null) {
                throw new \Exception('User not found or already logged out');
            }

            $this->tokenRepository->remove($user->findTokenByIpAndUserAgent($ip, $agent));
            $response = $user->logoutFromDevice($ip,$agent);
            $this->repository->save($user);
            return $response;
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

    }


}
