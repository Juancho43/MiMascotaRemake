<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Locations\Application\LocationManager;
use App\MiMascota\Users\Application\UserLogin;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
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
        $ip = '127.0.0.1';
        $agent = 'Mozilla/5.0';
        $name = "Juan";
        $email= "Juan@mail.com";
        $password = "Pepe";
        $this->user = User::create(
            Uuid::uuid4()->toString(),
            UserName::create($name),
            UserTelephone::create('12345678'),
            UserEmail::createNew($email),
            UserPassword::create($password),
        );
    }

//
    public function test__invoke()
    {
        //Arrange

        $this->user->getEmailObject()->verifyCode($this->user->getValidationCode());
        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with($this->user->getEmail())
            ->willReturn($this->user);
        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->user);

        //Act
        $token = $this->userLogin->__invoke($this->user->getEmail(), "Pepe",'127.0.0.1',"Mozilla/5.0");

        //Assert
        $this->assertNotNull($token);
        $this->assertEquals($this->user->getTokenByIp('127.0.0.1')->getValue(), $token);

    }

    public function test__invoke_fails_with_incorrect_password()
    {
        $this->expectException(\Exception::class);
        $this->user->getEmailObject()->verifyCode($this->user->getValidationCode());
        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with($this->user->getEmail())
            ->willReturn($this->user);


        //Act
        $token = $this->userLogin->__invoke($this->user->getEmail(), "ppp",'127.0.0.1',"Mozilla/5.0");

        //Assert
        $this->assertNull($token);


    }
    public function test__invoke_fails_with_incorrect_mail(){
        $this->expectException(\Exception::class);
        $incorrectEmail = "fail@mail.com";
        $this->user->getEmailObject()->verifyCode($this->user->getValidationCode());
        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with($incorrectEmail)
            ->willReturn(null);

        //Act
        $token = $this->userLogin->__invoke($incorrectEmail, "Pepe",'127.0.0.1',"Mozilla/5.0");

        //Assert
        $this->assertNull($token);
    }

    public function test__invoke_fails_with_not_validated_mail(){
        //Arrange
        $this->expectException(\Exception::class);
        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with($this->user->getEmail())
            ->willReturn($this->user);

        //Act
        $token = $this->userLogin->__invoke($this->user->getEmail(), "Pepe",'127.0.0.1',"Mozilla/5.0");

        //Assert
        $this->assertNull($token);
        $this->assertFalse($this->user->getEmailObject()->isVerified());
    }


}
