<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Application\ForumGetPosts;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumGetPostsTest extends KernelTestCase
{
    private ForumGetPosts $forumGetPosts;
    private PostRepository $repository;
    private Forum $forum;
    protected function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->repository = $this->createMock(PostRepository::class);
        $this->forumGetPosts = new ForumGetPosts($this->repository);
        $this->forum = Forum::create(
            Uuid::uuid4()->toString(),
            'Test Forum',
            SlugGenerator::generate('Test Forum'),
            'This is a test forum description.',
        );
        for ($i = 0; $i < 15; $i++) {
            $this->forum->addPost(
                Post::create(
                    Uuid::uuid4()->toString(),
                    'Test Post ' . ($i + 1),
                    SlugGenerator::generate('Test Post ' . ($i + 1)),
                    'This is the content of test post ' . ($i + 1) . '.',
                    $this->forum,
                    $this->createMock(User::class),
                    $this->createMock(Animal::class),
                    $this->createMock(Location::class),
                )
            );
        }

    }
  public function test__invoke(): void
  {
    $limit=12;
      $this->repository->expects($this->once())
          ->method('getByForumSlug')
          ->with($this->forum->getSlug())
          ->willReturn($this->forum->getPosts()->slice(0, $limit));
      $response = $this->forumGetPosts->__invoke($this->forum->getSlug(), 1, $limit);
      $this->assertCount($limit, $response);
  }

    public function test__invokeWithEmptyPosts(): void
    {
        $this->repository->expects($this->once())
            ->method('getByForumSlug')
            ->with($this->forum->getSlug())
            ->willReturn([]);
        $response = $this->forumGetPosts->__invoke($this->forum->getSlug(), 1, 10);
        $this->assertEmpty($response);
    }

    public function test__invokeWithInvalidForum(): void
    {
        $this->repository->expects($this->once())
            ->method('getByForumSlug')
            ->with('invalid-slug')
            ->willReturn([]);
        $response = $this->forumGetPosts->__invoke('invalid-slug', 1, 10);
        $this->assertEmpty($response);
    }

    public function test__invokeWithPagination(): void
    {
        $page = 2;
        $limit = 5;
        $expectedPosts = $this->forum->getPosts()->slice(($page - 1) * $limit, $limit);

        $this->repository->expects($this->once())
            ->method('getByForumSlug')
            ->with($this->forum->getSlug(), $page, $limit)
            ->willReturn($expectedPosts);

        $response = $this->forumGetPosts->__invoke($this->forum->getSlug(), $page, $limit);
        $this->assertCount(count($expectedPosts), $response);
    }
}
