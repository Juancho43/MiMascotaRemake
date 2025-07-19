<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;

class UserLogin
{
    public function __construct(
        private UserRepository $repository,
    )
    {

    }

    /**
     * @throws \Exception
     */
    public function __invoke(string $email, string $password): ?string
    {
        try {
            $user = $this->repository->findByMail($email);
            if( $user === null) {
                throw new \Exception('User not found');
            }

            $user->login($password);
            $this->repository->save($user);
            return $user->getToken();
        } catch (\Exception $e) {
           return null;
        }

    }

}
