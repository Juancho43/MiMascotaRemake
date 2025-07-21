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


    public function __invoke(string $email, string $password,string $ip, string $agent): ?string
    {
        try {
            $user = $this->repository->findByMail($email);
            if( $user === null) {
                throw new \Exception('User not found');
            }

            $token =  $user->loginWithDevice($password,$ip,$agent);
            $this->repository->save($user);
            return $token;
        } catch (\Exception $e) {
           throw $e;
        }

    }

}
