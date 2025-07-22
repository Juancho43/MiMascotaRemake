<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Users\Application\UserValidate;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use PHPUnit\Framework\MockObject\MockObject;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class UserValidateTest extends KernelTestCase
{
    private UserValidate $userValidate;
    private UserRepository|MockObject $userRepository;
    private string $ip = '127.0.0.1';
    private string $agent = 'test';
    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userValidate = new UserValidate($this->userRepository);
    }
    public function test__invoke()
    {

        //Arrange
        $user = User::create(
            Uuid::uuid4()->toString(),
            UserName::create('dsada'),
            UserTelephone::create('12345678'),
            UserEmail::create('dsada@dasd.com'),
            UserPassword::create('12345678'),
        );
        $code = $user->getEmailObject()->getCode();
        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with($user->getEmailObject()->getValue())
            ->willReturn($user);
        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($user);

        //Act

        $this->userValidate->__invoke($user->getEmailObject()->getValue(), $code,$this->ip,$this->agent);
        //Assert
        $this->assertTrue($user->getEmailObject()->isVerified());
    }

    public function test__invoke_fails()
    {
        $this->expectException(\Exception::class);
        $user = $this->createMock(User::class);
        $code = $user->getEmailObject()->getCode();

        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with('')
            ->willReturn(null);


        //Act
         $this->userValidate->__invoke('', $code,$this->ip,$this->agent);
        //Assert
        $this->assertFalse($user->getEmailObject()->isVerified());
        $this->assertNull($user->findTokenByIpAndUserAgent($this->ip,$this->agent));
    }

}
