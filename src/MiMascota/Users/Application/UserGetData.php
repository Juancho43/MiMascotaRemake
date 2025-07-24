<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\UserRepository;

final readonly class UserGetData
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
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'telephone' => $user->getTelephone(),
            'location' => $user->getUserLocation()->getLocation()->getCity(),
        ];
    }
}
