<?php

namespace App\Tests\MiMascota\Users\Application;

use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Application\UserSoftDelete;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserSoftDeleteTest extends TestCase
{
    private UserSoftDelete $userSoftDelete;
    private UserRepository $userRepository;

    private User $user;
    public function setUp(): void
    {

        $this->userRepository = $this->createMock(UserRepository::class);

        $this->userSoftDelete = new UserSoftDelete($this->userRepository, new UserGetById($this->userRepository));
        $this->user = UserMock::generate(Uuid::uuid4()->toString());
    }

    public function test__invoke() : void
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $this->userSoftDelete->__invoke(new GetUserByIdQuery($this->user->getId()));
        $this->assertTrue($this->user->getSoftDelete()->isDeleted());
    }
    public function test__invokeWithInvalidUser() : void
    {
        $id = Uuid::uuid4()->toString();
        $this->expectException(ModelNotFound::class);
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($id)
            ->willReturn(null);
        $this->userSoftDelete->__invoke(new GetUserByIdQuery($id));
    }
}
