<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Users\Application\Command\ChangeUserPasswordCommand;
use App\MiMascota\Users\Application\UserChangePassword;
use App\MiMascota\Users\Application\UserGetByEmail;
use App\MiMascota\Users\Application\UserRegister;
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
use Symfony\Component\DependencyInjection\Container;

class UserChangePasswordTest extends KernelTestCase
{
    private UserGetByEmail $userGetByEmail;
    private UserChangePassword $userChangePassword;
    private UserRepository|MockObject $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userGetByEmail = new UserGetByEmail($this->userRepository);
        $this->userChangePassword = new UserChangePassword($this->userRepository, $this->userGetByEmail);
    }

    public function testInvokeSuccessfully(): void
    {
        // Arrange
        $name = "Juan";
        $email = "Juan@mail.com";
        $oldPassword = "OldPassword123";
        $newPassword = "NewPassword123";

        // Crear usuario con contraseña antigua
        $user = UserMock::generate(Uuid::uuid4()->toString(), $name, '222222', $email, $oldPassword);

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
        $result = $this->userChangePassword->__invoke(new ChangeUserPasswordCommand($email, $newPassword));


        // Assert
        $this->assertTrue($result);
        $newPasswordObject = $user->getPassword();
        $this->assertNotEquals($oldPasswordObject->getValue(), $newPasswordObject->getValue());
        $this->assertTrue($newPasswordObject->verify($newPassword));

        $this->assertNotNull($user->getTimeStamp()->getUpdatedAt());
    }
}
