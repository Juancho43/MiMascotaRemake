<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Users\Application\UserValidate;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use PHPUnit\Framework\MockObject\MockObject;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class UserValidateTest extends KernelTestCase
{
    private UserValidate $userValidate;
    private UserRepository|MockObject $userRepository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userValidate = new UserValidate($this->userRepository);
    }
    public function test__invoke()
    {

        //Arrange
        $name = "Juan";
        $email= "Juan@mail.com";
        $password = "Pepe";
        $user = User::create(
            Uuid::uuid4()->toString(),
            $name,
            UserEmail::createNew($email),
            UserPassword::create($password),
        );
        $code = $user->getEmailObject()->getCode();

        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with($email)
            ->willReturn($user);
        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($user);

        //Act

        $token = $this->userValidate->__invoke($email, $code);
        //Assert
        $this->assertTrue($user->getEmailObject()->isVerified());
        $this->assertNotNull($token, $user->getToken());
    }

    public function test__invoke_fails()
    {
        $this->expectException(\Exception::class);
        $name = "Juan";
        $email= "Juan@mail.com";
        $password = "Pepe";
        $user = User::create(
            Uuid::uuid4()->toString(),
            $name,
            UserEmail::createNew($email),
            UserPassword::create($password),
        );
        $code = $user->getEmailObject()->getCode();

        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with('')
            ->willReturn(null);


        //Act

         $this->userValidate->__invoke('', $code);
        //Assert
        $this->assertFalse($user->getEmailObject()->isVerified());
        $this->assertNull($user->getToken());
    }

}
