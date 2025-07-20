<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;

class UserChangePassword
{

    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $email, string $newPassword): bool
    {
        try {
            $user = $this->repository->findByMail($email);
            if ($user === null) {
                throw new \Exception('User not found');
            }

            $response = $user->changePassword($newPassword);
            $this->repository->save($user);
            return $response;
        }catch (\Exception $exception){
            throw $exception;
        }

    }
}
