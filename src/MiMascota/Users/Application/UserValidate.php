<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;

class UserValidate
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $email, string $code): ?string
    {
        $user = $this->repository->findByMail($email);

        if ($user === null) {
            return null;
        }

        $response = $user->verifyCodeAndLogin($code);
        if($response) {
            $this->repository->save($user);
        };

        return $user->getToken();
    }

}
