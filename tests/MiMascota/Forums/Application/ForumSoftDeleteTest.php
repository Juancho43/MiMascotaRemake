<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\ForumSoftDelete;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumSoftDeleteTest extends KernelTestCase
{
    private ForumSoftDelete $forumSoftDelete;
    private ForumRepository $forumRepository;
    public function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->forumSoftDelete = new ForumSoftDelete($this->forumRepository);
    }

    public function test__invoke(): void
    {
        $forum = Forum::create(Uuid::uuid4()->toString(), 'Test Forum', 'test-forum', 'This is a test forum');

        $this->forumRepository->expects($this->once())->method('search')->with($forum->getId())->willReturn($forum);
        $this->forumRepository->expects($this->once())->method('save');

        $forum = $this->forumSoftDelete->__invoke($forum->getId());

        $this->assertInstanceOf(Forum::class, $forum);
        $this->assertTrue($forum->getSoftDelete()->isDeleted());

    }

    public function test_invokeFails()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Forum not found');

        $forumId = Uuid::uuid4()->toString();
        $this->forumRepository->expects($this->once())->method('search')->with($forumId)->willReturn(null);

        $this->forumSoftDelete->__invoke($forumId);
    }
}
