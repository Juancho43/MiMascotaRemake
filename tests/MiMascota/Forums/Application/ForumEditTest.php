<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\ForumCreator;
use App\MiMascota\Forums\Application\ForumEdit;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumEditTest extends KernelTestCase
{
    private ForumEdit $forumEdit;
    private ForumRepository $forumRepository;
    public function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->forumEdit = new ForumEdit($this->forumRepository);
    }

    public function test__invoke(): void
    {

        $forum = Forum::create(Uuid::uuid4()->toString(), 'Test Forum', 'test-forum', 'This is a test forum');
        $forumName = "Test New Forum";
        $forumSlug = "test-new-forum";
        $forumDescription = "This is a new test forum description.";
        $this->forumRepository->expects($this->once())->method('search')->with($forum->getId())->willReturn($forum);
        $this->forumRepository->expects($this->once())->method('save');

        $forum = $this->forumEdit->__invoke($forum->getId(), $forumName, $forumDescription);

        $this->assertInstanceOf(Forum::class, $forum);
        $this->assertEquals($forumName, $forum->getName());
        $this->assertEquals($forumSlug, $forum->getSlug());
        $this->assertEquals($forumDescription, $forum->getDescription());

    }


    public function test_invokeFails(){
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Forum not found');

        $forumId = Uuid::uuid4()->toString();
        $this->forumRepository->expects($this->once())->method('search')->with($forumId)->willReturn(null);

        $this->forumEdit->__invoke($forumId, 'New Forum Name', 'New Forum Description');
    }


}
