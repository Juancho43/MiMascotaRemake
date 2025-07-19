<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;

class UserLogout
{
    public function __construct(
        private UserRepository $repository,
    )
    {
    }

    public function __invoke(string $token): void
    {
        try {
            $user = $this->repository->findByToken($token);

            if ($user === null) {
                throw new \Exception('User not found or already logged out');
            }

            $user->logout();
            $this->repository->save($user);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

    }


}
