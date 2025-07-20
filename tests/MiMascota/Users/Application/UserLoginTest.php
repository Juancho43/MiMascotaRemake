<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Locations\Application\LocationManager;
use App\MiMascota\Users\Application\UserLogin;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserLoginTest extends KernelTestCase
{
    private UserLogin $userLogin;
    private UserRepository | MockObject $userRepository;
    private User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository= $this->createMock(UserRepository::class);
        $this->userLogin = new UserLogin($this->userRepository);
        $name = "Juan";
        $email= "Juan@mail.com";
        $password = "Pepe";
        $this->user = User::create(
            Uuid::uuid4()->toString(),
            $name,
            UserEmail::createNew($email),
            UserPassword::create($password),
        );
    }

//
//    public function test__invoke()
//    {
//        //Arrange
//
//        $this->user->getEmailObject()->verifyCode($this->user->getValidationCode());
//        $this->userRepository
//            ->expects($this->once())
//            ->method('findByMail')
//            ->with($this->user->getEmail())
//            ->willReturn($this->user);
//        $this->userRepository
//            ->expects($this->once())
//            ->method('save')
//            ->with($this->user);
//
//        //Act
//        $token = $this->userLogin->__invoke($this->user->getEmail(), "Pepe");
//
//        //Assert
//        $this->assertNotNull($token);
//        $this->assertEquals($this->user->getToken(), $token);
//
//    }
//
//    public function test__invoke_fails_with_incorrect_password()
//    {
//        $this->user->getEmailObject()->verifyCode($this->user->getValidationCode());
//        $this->userRepository
//            ->expects($this->once())
//            ->method('findByMail')
//            ->with($this->user->getEmail())
//            ->willReturn($this->user);
//
//
//        //Act
//        $token = $this->userLogin->__invoke($this->user->getEmail(), "pepe");
//
//        //Assert
//        $this->assertNull($token);
//
//
//    }
//    public function test__invoke_fails_with_incorrect_mail(){
//        $incorrectEmail = "fail@mail.com";
//        $this->user->getEmailObject()->verifyCode($this->user->getValidationCode());
//        $this->userRepository
//            ->expects($this->once())
//            ->method('findByMail')
//            ->with($incorrectEmail)
//            ->willReturn(null);
//
//        //Act
//        $token = $this->userLogin->__invoke($incorrectEmail, "Pepe");
//
//        //Assert
//        $this->assertNull($token);
//    }
//
//    public function test__invoke_fails_with_not_validated_mail(){
//        //Arrange
//
//        $this->userRepository
//            ->expects($this->once())
//            ->method('findByMail')
//            ->with($this->user->getEmail())
//            ->willReturn($this->user);
//
//        //Act
//        $token = $this->userLogin->__invoke($this->user->getEmail(), "Pepe");
//
//        //Assert
//        $this->assertNull($token);
//        $this->assertFalse($this->user->getEmailObject()->isVerified());
//    }
}
