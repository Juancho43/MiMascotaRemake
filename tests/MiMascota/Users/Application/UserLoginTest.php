<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Locations\Application\LocationCreator;
use App\MiMascota\Users\Application\Command\LoginUserCommand;
use App\MiMascota\Users\Application\UserGetByEmail;
use App\MiMascota\Users\Application\UserLogin;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserLoginTest extends KernelTestCase
{
    private UserGetByEmail $userGetByEmail;
    private UserLogin $userLogin;
    private UserRepository | MockObject $userRepository;
    private User $user;
    private string $ip = '127.0.0.1';
    private string $agent = 'Mozilla/5.0';
    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository= $this->createMock(UserRepository::class);
        $this->userGetByEmail = new UserGetByEmail($this->userRepository);
        $this->userLogin = new UserLogin($this->userRepository, $this->userGetByEmail);

        $name = "Juan";
        $email= "Juan@mail.com";
        $password = "Pepe";
        $this->user = UserMock::generate(Uuid::uuid4()->toString(), $name, '3333333',$email,$password);
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
        $token = $this->userLogin->__invoke(new LoginUserCommand($this->user->getEmail(), "Pepe",$this->ip,$this->agent));

        //Assert
        $this->assertNotNull($token);
        $this->assertEquals($this->user->getTokenByIp($this->ip)->getValue(), $token);

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

        $token = $this->userLogin->__invoke(new LoginUserCommand($this->user->getEmail(), "Pepa",$this->ip,$this->agent));
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

        $token = $this->userLogin->__invoke(new LoginUserCommand($incorrectEmail, "Pepe",$this->ip,$this->agent));
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

        $token = $this->userLogin->__invoke(new LoginUserCommand($this->user->getEmail(), "Pepe",$this->ip,$this->agent));
        //Assert
        $this->assertNull($token);
        $this->assertFalse($this->user->getEmailObject()->isVerified());
    }


}
