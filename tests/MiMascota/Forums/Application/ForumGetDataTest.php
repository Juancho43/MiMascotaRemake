<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\ForumGetBySlug;
use App\MiMascota\Forums\Application\Query\GetForumBySlugQuery;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Shared\SlugGenerator;
use App\Tests\MiMascota\Shared\ForumMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumGetDataTest extends TestCase
{
    private ForumGetBySlug $forumCreator;
    private ForumRepository $forumRepository;
    private Forum $forum;
    public function setUp(): void
    {

        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->forumCreator = new ForumGetBySlug($this->forumRepository);
        $this->forum = ForumMock::generate(Uuid::uuid4()->toString());
    }

    public function test__invoke(): void
    {

        $slug = SlugGenerator::generate('Test Forum');

        $this->forumRepository->expects($this->once())->method('getBySlug')
            ->with($slug)
            ->willReturn($this->forum);

        $forum = $this->forumCreator->__invoke(new GetForumBySlugQuery($slug));

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

        $forum = $this->forumCreator->__invoke(new GetForumBySlugQuery($slug));
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

        $forum = $this->forumCreator->__invoke(new GetForumBySlugQuery($slug));
        $this->assertNull($forum);
    }
}
