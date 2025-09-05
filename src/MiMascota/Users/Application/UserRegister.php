<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Locations\Application\LocationCreator;
use App\MiMascota\Locations\Domain\LocationResolver;
use App\MiMascota\Locations\Domain\UserLocation;
use App\MiMascota\Users\Application\Command\CreateUserCommand;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserRole;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use Ramsey\Uuid\Uuid;

final readonly class UserRegister
{
     public function __construct(
         private UserRepository $repository,
         private LocationResolver $locationResolver
     )
     {
     }

     public function __invoke(CreateUserCommand $command): User
     {
          $location = $this->locationResolver->getLocation($command->latitude, $command->longitude);
          $user = User::create(
              Uuid::uuid4()->toString(),
              UserName::create($command->name),
              UserTelephone::create($command->telephone),
              UserEmail::create($command->email),
              UserPassword::create($command->password),
              UserRole::generate($command->role),
          );

          $user->setLocation(UserLocation::create(Uuid::uuid4()->toString(),$user,$location));
          $this->repository->save($user);

          return $user;
     }
}
