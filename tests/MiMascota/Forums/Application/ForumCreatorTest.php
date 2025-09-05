<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\Controller\Forums\ForumCreateController;
use App\MiMascota\Forums\Application\Command\CreateForumCommand;
use App\MiMascota\Forums\Application\ForumCreator;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Users\Application\UserChangePassword;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserRole;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumCreatorTest extends TestCase
{

    private ForumCreator $forumCreator;
    private ForumRepository $forumRepository;
    private User $user;
    public function setUp(): void
    {

        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->forumCreator = new ForumCreator($this->forumRepository);
        $this->user = UserMock::generate(Uuid::uuid4()->toString());
        $this->user->setRole(UserRole::generate(UserRole::ADMIN));
    }

    public function test__invoke(): void
    {

        $forumName = "Test Forum";
        $forumDescription = "This is a test forum description";

        $this->forumRepository->expects($this->once())->method('save');
        $command = new CreateForumCommand(
            $forumName,
            $forumDescription,

        );
        $forum = $this->forumCreator->__invoke($command);

        $this->assertEquals($forum->getName(), $forumName);
        $this->assertEquals($forum->getDescription(), $forumDescription);

    }
   public function test__invokeFailsWithNotPermisson()
    {
       $this->expectException(\Exception::class);
         $this->expectExceptionMessage('You do not have permission to create a forum');
        $this->user->setRole(UserRole::generate(UserRole::USER));

        $this->forumCreator->__invoke(new CreateForumCommand('name', 'description'));
    }


}



