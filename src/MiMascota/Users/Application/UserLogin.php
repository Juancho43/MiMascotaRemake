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

    public function __invoke(string $email, string $password): ?string
    {
        $user = $this->repository->findByMail($email);

        if (!password_verify($password,$user->getPassword()->getValue())) {
           echo 'falso';
            return null; // Invalid credentials
        }
        if ($user->getToken() !== null) {
            return $user->getToken();
        }
        $user->login();
        $this->repository->save($user);
        return $user->getToken();
    }

}
