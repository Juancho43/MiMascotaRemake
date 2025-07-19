<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Locations\Application\LocationManager;
use App\MiMascota\Locations\Domain\UserLocation;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use Ramsey\Uuid\Uuid;

class UserRegister
{
     public function __construct(
         private UserRepository $repository,
         private LocationManager $locationManager
     )
     {
     }

     public function __invoke(string $name, string $email, string $password, string $latitude, string $longitude): User
     {
         $location = $this->locationManager->__invoke($latitude, $longitude);
         $user = User::create(
             Uuid::uuid4()->toString(),
             $name,
             UserEmail::createNew($email),
             UserPassword::create($password),
         );

         $user->setLocation(new UserLocation(Uuid::uuid4()->toString(),$user,$location));
         $this->repository->save($user);

         return $user;
     }
}
