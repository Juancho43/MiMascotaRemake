<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Users\Application\UserChangePassword;
use App\MiMascota\Users\Application\UserRegister;
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
use Symfony\Component\DependencyInjection\Container;

class UserChangePasswordTest extends KernelTestCase
{

    private UserChangePassword $userChangePassword;
    private UserRepository|MockObject $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userChangePassword = new UserChangePassword($this->userRepository);
    }

    public function testInvokeSuccessfully(): void
    {
        // Arrange
        $name = "Juan";
        $email = "Juan@mail.com";
        $oldPassword = "OldPassword123";
        $newPassword = "NewPassword123";

        // Crear usuario con contraseña antigua
        $user = User::create(
            Uuid::uuid4()->toString(),
            UserName::create($name),
            UserTelephone::create('222222'),
            UserEmail::create($email),
            UserPassword::create($oldPassword)
        );

        // Obtener contraseña antigua para verificar después
        $oldPasswordObject = $user->getPassword();

        // Configurar mock del repositorio
        $this->userRepository
            ->expects($this->once())
            ->method('findByMail')
            ->with($email)
            ->willReturn($user);

        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($user);

        // Act
        $result = $this->userChangePassword->__invoke($email, $newPassword);


        // Assert
        $this->assertTrue($result);
        $newPasswordObject = $user->getPassword();
        $this->assertNotEquals($oldPasswordObject->getValue(), $newPasswordObject->getValue());
        $this->assertTrue($newPasswordObject->verify($newPassword));
    }
}
