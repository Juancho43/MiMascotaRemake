<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserValidate
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $email, string $code, string $ip, string $agent): string
    {

            $user = $this->repository->findByMail($email);
            if ($user === null) {
                throw new \Exception('User not found');
            }
            $token = $user->verifyCodeAndLoginWithDevice($code,$ip,$agent);
            $this->repository->save($user);
            return $token;


    }

}
