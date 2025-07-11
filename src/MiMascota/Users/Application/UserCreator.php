<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use Ramsey\Uuid\Uuid;

final readonly class UserCreator
{
     public function __construct(private UserRepository $repository)
     {

     }

     public function __invoke(string $name, string $email, string $password): User
     {
         $user = User::create(Uuid::uuid4()->toString(), $name,$email, UserPassword::create($password));
         $this->repository->save($user);
         return $user;
     }
}
