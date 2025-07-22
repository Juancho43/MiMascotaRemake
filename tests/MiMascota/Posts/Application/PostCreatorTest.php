<?php

namespace App\Tests\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\PostCreator;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostCreatorTest extends KernelTestCase
{
    private PostCreator $creator;
    private PostRepository $repository;
    private AnimalRepository $animalRepository;
    private ForumRepository $forumRepository;
    private UserRepository $userRepository;
    private LocationRepository $locationRepository;
    private Animal $animal;
    private Forum $forum;
    private User $user;
    private Location $location;
    public function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->repository = $this->createMock(PostRepository::class);
        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->locationRepository = $this->createMock(LocationRepository::class);
        $this->creator = new PostCreator(
            $this->repository,
            $this->animalRepository,
            $this->forumRepository,
            $this->userRepository,
            $this->locationRepository
        );
        $this->animal = $this->createMock(Animal::class);
        $this->forum = $this->createMock(Forum::class);
        $this->user = $this->createMock(User::class);
        $this->location = $this->createMock(Location::class);
    }

    public function test__invoke(): void
    {
        $postTitle = "Test Post Title";
        $postContent = "This is a test post content.";

        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $this->locationRepository->expects($this->once())
            ->method('search')
            ->with($this->location->getId())
            ->willReturn($this->location);
        $this->animalRepository->expects($this->once())
            ->method('search')
            ->with($this->animal->getId())
            ->willReturn($this->animal);
        $this->forumRepository->expects($this->once())
            ->method('search')
            ->with($this->forum->getId())
            ->willReturn($this->forum);

        $this->repository->expects($this->once())->method('save');

        $post = $this->creator->__invoke(
            $postTitle,
            $postContent,
            $this->animal->getId(),
            $this->forum->getId(),
            $this->user->getId(),
            $this->location->getId()
        );

        $this->assertEquals($postTitle, $post['title']);
        $this->assertEquals($postContent, $post['content']);
        $this->assertEquals($this->animal->getId(), $post['animal']['id']);
        $this->assertEquals($this->forum->getName(), $post['forum']);
        $this->assertEquals($this->user->getName(), $post['user']);
        $this->assertEquals($this->location->getId(), $post['location']['id']);





    }
    public function test__invokeWithNonExistentAnimal(): void
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $this->locationRepository->expects($this->once())
            ->method('search')
            ->with($this->location->getId())
            ->willReturn($this->location);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Animal not found");

        $postTitle = "Test Post Title";
        $postContent = "This is a test post content.";

        $this->animalRepository->expects($this->once())
            ->method('search')
            ->with($this->animal->getId())
            ->willReturn(null);

        $this->creator->__invoke(
            $postTitle,
            $postContent,
            $this->animal->getId(),
            $this->forum->getId(),
            $this->user->getId(),
            $this->location->getId()
        );
    }

    public function test__invokeWithNonExistentForum(): void
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $this->locationRepository->expects($this->once())
            ->method('search')
            ->with($this->location->getId())
            ->willReturn($this->location);
        $this->animalRepository->expects($this->once())
            ->method('search')
            ->with($this->animal->getId())
            ->willReturn($this->animal);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Forum not found");

        $postTitle = "Test Post Title";
        $postContent = "This is a test post content.";

        $this->forumRepository->expects($this->once())
            ->method('search')
            ->with($this->forum->getId())
            ->willReturn(null);




        $this->creator->__invoke(
            $postTitle,
            $postContent,
            $this->animal->getId(),
            $this->forum->getId(),
            $this->user->getId(),
            $this->location->getId()
        );
    }

    public function test__invokeWithNonExistentUser(): void
    {

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("User not found");

        $postTitle = "Test Post Title";
        $postContent = "This is a test post content.";

        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn(null);

        $this->creator->__invoke(
            $postTitle,
            $postContent,
            $this->animal->getId(),
            $this->forum->getId(),
            $this->user->getId(),
            $this->location->getId()
        );
    }

    public function test__invokeWithNonExistentLocation(): void
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Location not found");

        $postTitle = "Test Post Title";
        $postContent = "This is a test post content.";

        $this->locationRepository->expects($this->once())
            ->method('search')
            ->with($this->location->getId())
            ->willReturn(null);

        $this->creator->__invoke(
            $postTitle,
            $postContent,
            $this->animal->getId(),
            $this->forum->getId(),
            $this->user->getId(),
            $this->location->getId()
        );
    }
}
