<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\Command\EditForumCommand;
use App\MiMascota\Forums\Application\ForumCreator;
use App\MiMascota\Forums\Application\ForumEdit;
use App\MiMascota\Forums\Application\ForumGetById;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserRole;
use App\Tests\MiMascota\Shared\ForumMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumEditTest extends TestCase
{
    private ForumEdit $forumEdit;
    private ForumRepository $forumRepository;
    private UserRepository $userRepository;
    private User $user;
    public function setUp(): void
    {

        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->forumEdit = new ForumEdit($this->forumRepository,new ForumGetById($this->forumRepository), new UserGetById($this->userRepository));
        $this->user = UserMock::generate(Uuid::uuid4()->toString());
        $this->user->setRole(UserRole::generate(UserRole::ADMIN));
    }

    public function test__invoke(): void
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $forum = ForumMock::generate(Uuid::uuid4()->toString(), 'Test Forum',  'This is a test forum');
        $forumName = "Test New Forum";
        $forumSlug = "test-new-forum";
        $forumDescription = "This is a new test forum description.";
        $this->forumRepository->expects($this->once())->method('search')->with($forum->getId())->willReturn($forum);
        $this->forumRepository->expects($this->once())->method('save');
        $command = new EditForumCommand(
            $forum->getId(),
            $forumName,
            $forumDescription,
            $this->user->getId()
        );
        $forum = $this->forumEdit->__invoke($command);

        $this->assertEquals($forumName, $forum->getName());
        $this->assertEquals($forumSlug, $forum->getSlug());
        $this->assertEquals($forumDescription, $forum->getDescription());

    }


}
