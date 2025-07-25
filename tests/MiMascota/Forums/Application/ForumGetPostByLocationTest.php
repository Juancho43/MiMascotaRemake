<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Application\ForumGetPostByLocation;
use App\MiMascota\Forums\Application\ForumGetPosts;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumGetPostByLocationTest extends KernelTestCase
{
    private ForumGetPostByLocation $forumGetPosts;
    private PostRepository $repository;
    private ForumRepository $forumRepository;
    private LocationRepository $locationRepository;
    private Forum $forum;
    private Location $location;
    protected function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->repository = $this->createMock(PostRepository::class);
        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->locationRepository = $this->createMock(LocationRepository::class);
        $this->forumGetPosts = new ForumGetPostByLocation(
            $this->repository,
            $this->locationRepository,
            $this->forumRepository
        );
        $this->forum = Forum::create(
            Uuid::uuid4()->toString(),
            'Test Forum',
            SlugGenerator::generate('Test Forum'),
            'This is a test forum description.',
        );
        $this->location = Location::create(
            Uuid::uuid4()->toString(),
            'Test Location',
            'Test Country',
            '-23.222',
            '-45.333'
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
                    $this->location,
                )
            );
        }

    }

    public function test__invoke() : void
    {
        $this->forumRepository->expects($this->once())
            ->method('getBySlug')
            ->with($this->forum->getSlug())
            ->willReturn($this->forum);
        $this->locationRepository->expects($this->once())
            ->method('search')
            ->with($this->location->getId())
            ->willReturn($this->location);
        $this->repository->expects($this->once())
            ->method('getByForumFilterLocation')
            ->with($this->forum->getSlug(), $this->location->getId(), 1, 10)
            ->willReturn($this->forum->getPosts()->slice(0, 10));
        $result = $this->forumGetPosts->__invoke($this->forum->getSlug(), $this->location->getId(), 1, 10);
        $this->assertCount(10,$result);
    }
    public function test__invokeFailsWithInvalidSlug() : void
    {
        $this->expectException(ModelNotFound::class);
        $this->forumRepository->expects($this->once())
            ->method('getBySlug')
            ->with('dsada')
            ->willReturn(null);
        $result = $this->forumGetPosts->__invoke('dsada', $this->location->getId(), 1, 10);
    }
    public function test__invokeFailsWithInvalidLocationId() : void
    {
        $this->forumRepository->expects($this->once())
            ->method('getBySlug')
            ->with($this->forum->getSlug())
            ->willReturn($this->forum);
        $this->expectException(ModelNotFound::class);
        $this->locationRepository->expects($this->once())
            ->method('search')
            ->with('11111')
            ->willReturn(null);
        $result = $this->forumGetPosts->__invoke($this->forum->getSlug(), '11111', 1, 10);
    }
}
