<?php

namespace App\MiMascota\Users\Infrastructure;

use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class IsUserLoggedIn
{
    public function __construct(private UserRepository $repository){

    }

    public function __invoke(string $token) : ?User
    {
        return $this->repository->findByToken($this->format($token));

    }
    private function format(string $header) : string
    {
        $token = null;
        if ($header && str_starts_with($header, 'Bearer ')) {
            $token = substr($header, 7); // Remove "Bearer " prefix (7 characters)
        }
        return $token;
    }

}
