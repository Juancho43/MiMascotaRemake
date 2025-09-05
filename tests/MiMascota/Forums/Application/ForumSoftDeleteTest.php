<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\ForumSoftDelete;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\ForumMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumSoftDeleteTest extends TestCase
{
    private ForumSoftDelete $forumSoftDelete;
    private ForumRepository $forumRepository;
    private User $user;
    public function setUp(): void
    {

        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->forumSoftDelete = new ForumSoftDelete($this->forumRepository);
        $this->user =UserMock::generate(Uuid::uuid4()->toString(),role: 'admin');
    }

    public function test__invoke(): void
    {
        $forum = ForumMock::generate(Uuid::uuid4()->toString(), 'Test Forum', 'This is a test forum');

        $this->forumRepository->expects($this->once())->method('search')->with($forum->getId())->willReturn($forum);
        $this->forumRepository->expects($this->once())->method('save');

        $forum = $this->forumSoftDelete->__invoke($forum->getId(),$this->user);

        $this->assertInstanceOf(Forum::class, $forum);
        $this->assertTrue($forum->getSoftDelete()->isDeleted());

    }

    public function test_invokeFails()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Forum not found');

        $forumId = Uuid::uuid4()->toString();
        $this->forumRepository->expects($this->once())->method('search')->with($forumId)->willReturn(null);

        $this->forumSoftDelete->__invoke($forumId, $this->user);
    }
}
