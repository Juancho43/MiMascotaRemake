<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Users\Application\Command\LogoutUserCommand;
use App\MiMascota\Users\Application\UserGetByToken;
use App\MiMascota\Users\Application\UserLogin;
use App\MiMascota\Users\Application\UserLogout;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\UserTokenRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\MockObject\MockObject;

use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserLogoutTest extends KernelTestCase
{
    private UserGetByToken $getByToken;
    private UserLogout $userLogout;
    private UserRepository | MockObject $userRepository;
    private User $user;
    private string $ip;
    private string $agent;
    protected function setUp(): void
    {
        parent::setUp();
        $this->ip = '127.0.0.1';
        $this->agent = 'Mozilla/5.0';
        $name = "Juan";
        $email= "Juan@mail.com";
        $password = "Pepe";
        $this->user = UserMock::generate(
            Uuid::uuid4()->toString(), $name, '3333333',$email,$password);
        $this->userRepository= $this->createMock(UserRepository::class);
        $this->getByToken = new UserGetByToken($this->userRepository);
        $this->userLogout = new UserLogout($this->userRepository,$this->createMock(UserTokenRepository::class), $this->getByToken);
        $this->user->verifyCodeAndLoginWithDevice($this->user->getValidationCode(),$this->ip, $this->agent);
    }

    public function test__invoke()
    {
        $this->userRepository->expects($this->once())->method('findByToken')->willReturn($this->user);
        $command = new LogoutUserCommand(
            $this->user->findTokenByIpAndUserAgent($this->ip, $this->agent)->getValue(),
            $this->ip,
            $this->agent
        );
        $this->assertTrue($this->userLogout->__invoke($command));
    }

    public function test__invoke_fails(){
        $this->expectException(\Exception::class);
        $command = new LogoutUserCommand(
            $this->user->findTokenByIpAndUserAgent($this->ip,$this->agent)->getValue(),
            $this->ip,
            $this->agent
        );
        $this->assertFalse($this->userLogout->__invoke($command));
    }
}
