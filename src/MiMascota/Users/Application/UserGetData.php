<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;

class UserGetData
{
    public function __construct(
        private UserRepository $repository,
    )
    {

    }

    public function __invoke(string $token): array
    {
        $user = $this->repository->findByToken($token);

        if ($user === null) {
            throw new \InvalidArgumentException("User not found");
        }

        return [
//            'id' => $user->getId(),
            'email' => $user->getEmailObject()->getEmail(),
            'name' => $user->getName(),

//            'surname' => $user->getSurname(),
//            'phone' => $user->getPhone(),
//            'address' => $user->getAddress(),
//            'city' => $user->getCity(),
//            'country' => $user->getCountry(),
        ];
    }
}
