<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Locations\Domain\ValueObject\LocationCity;
use App\MiMascota\Users\Application\Command\EditUserCommand;
use App\MiMascota\Users\Application\UserEdit;
use App\MiMascota\Users\Application\UserGetByEmail;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\LocationMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserEditTest extends TestCase
{
    private UserEdit $userEdit;
    private $userRepository;

    private User $user;
    public function setUp(): void
    {
        $this->userRepository = $this->createMock('App\MiMascota\Users\Domain\UserRepository');
        $this->userGetByEmail = new UserGetByEmail($this->userRepository);
        $this->locationManager = $this->createMock('App\MiMascota\Locations\Domain\LocationResolver');

        $this->userEdit = new UserEdit(
            $this->userRepository,
            $this->userGetByEmail,
            $this->locationManager
        );
        $this->user = UserMock::generate(Uuid::uuid4()->toString());
    }
    public function test__invoke()
    {
        $this->userRepository->expects($this->once())
            ->method('findByMail')
            ->with($this->user->getEmail())
            ->willReturn($this->user);
        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($this->user);

        $this->locationManager->expects($this->once())
            ->method('getLocation')
            ->willReturn(LocationMock::generate(
                Uuid::uuid4()->toString(),
                'Madrid',
                'Spain',
                '40.4167',
                '-3.7037'
            ));


        $command = new EditUserCommand(
            $this->user->getId(),
            'prueba',
            'test@mail.com',
            '123456789',
            'admin',
            '40.416775',
            '-3.703790'
        )
        ;
        $result = $this->userEdit->__invoke($command);

        $this->assertEquals($command->email, $result->getEmail());
        $this->assertEquals($command->name, $result->getName());
        $this->assertEquals($command->telephone, $result->getTelephone());
        $this->assertEquals($command->rol, $result->getRole()->getRole());


    }
}
