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
        $user = $this->repository->findByMail( $email);

        if(!$user->getEmailObject()->isVerified()) {
            throw new \InvalidArgumentException("Email not verified");
        }

        $user->getPassword()->verify($password);

        if ($user->getToken() !== null ) {
            return $user->getToken();
        }

        $user->login();
        $this->repository->save($user);
        return $user->getToken();
    }

}
