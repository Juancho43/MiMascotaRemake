<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Locations\Application\LocationCreator;
use App\MiMascota\Locations\Domain\LocationResolver;
use App\MiMascota\Locations\Domain\UserLocation;
use App\MiMascota\Users\Application\Command\EditUserCommand;
use App\MiMascota\Users\Application\Query\GetUserByEmailQuery;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserRole;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use Ramsey\Uuid\Uuid;

final readonly class UserEdit
{
    public function __construct(
        private UserRepository $userRepository,
        private UserGetByEmail $userGetByEmail,
        private LocationResolver $locationManager
    )
    {

    }

    public function __invoke(EditUserCommand $command) : User
    {
        $user = $this->userGetByEmail->__invoke(new GetUserByEmailQuery($command->email));
        $user->setName(UserName::create($command->name));
        $user->setTelephone(UserTelephone::create($command->telephone));
        $user->setRole(UserRole::generate($command->rol));
        $user->getUserLocation()->setLocation($this->locationManager->getLocation($command->latitude, $command->longitude));


        $user->getTimeStamp()->update();

        $this->userRepository->save($user);
        return $user;
    }
}
