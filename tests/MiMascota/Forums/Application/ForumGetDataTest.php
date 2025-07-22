<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\ForumGetData;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Shared\SlugGenerator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumGetDataTest extends KernelTestCase
{
    private ForumGetData $forumCreator;
    private ForumRepository $forumRepository;
    private Forum $forum;
    public function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->forumCreator = new ForumGetData($this->forumRepository);
        $this->forum = Forum::create(
            Uuid::uuid4()->toString(),
            "Test Forum",
            SlugGenerator::generate('Test Forum'),
            'This is a test forum description.'
        );
    }

    public function test__invoke(): void
    {

        $slug = SlugGenerator::generate('Test Forum');

        $this->forumRepository->expects($this->once())->method('getBySlug')
            ->with($slug)
            ->willReturn($this->forum);

        $forum = $this->forumCreator->__invoke($slug);

        $this->assertInstanceOf(Forum::class, $forum);
        $this->assertEquals($this->forum->getId(), $forum->getId());
        $this->assertEquals($this->forum->getName(), $forum->getName());
        $this->assertEquals($this->forum->getSlug(), $forum->getSlug());

    }

    public function test__invoke__fails()
    {
        $slug = 'non-existing-slug';
        $this->expectException(\Exception::class);
        $this->forumRepository->expects($this->once())->method('getBySlug')
            ->with($slug)
            ->willReturn(null);

        $forum = $this->forumCreator->__invoke($slug);
        $this->assertNull($forum);
    }

    public function test__invoke__failsWithForumDeleted()
    {
        $this->expectException(\Exception::class);
        $slug = SlugGenerator::generate('Test Forum');
        $this->forum->getSoftDelete()->markAsDeleted();
        $this->forumRepository->expects($this->once())->method('getBySlug')
            ->with($slug)
            ->willReturn(null);

        $forum = $this->forumCreator->__invoke($slug);
        $this->assertNull($forum);
    }
}
