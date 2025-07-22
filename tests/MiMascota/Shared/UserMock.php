<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;

class UserMock
{

    public static function generateUser(
        string $id = '',
        string $name = 'Test User',
        string $telephone = '1234567890',
        string $email = 'test@mail.com',
        string $password = 'password123',

    ) : User{
        return User::create(
            $id,
            UserName::create($name),
            UserTelephone::create($telephone),
            UserEmail::create($email),
            UserPassword::create($password)
        );
    }
}
