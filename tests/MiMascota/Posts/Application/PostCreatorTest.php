<?php

namespace App\Tests\MiMascota\Posts\Application;

use App\MiMascota\Animals\Application\AnimalGetById;
use App\MiMascota\Animals\Application\Query\GetAnimalByIdQuery;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Forums\Application\ForumGetBySlug;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Application\LocationGetById;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\Command\CreatePostCommand;
use App\MiMascota\Posts\Application\PostCreator;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostCreatorTest extends TestCase
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


        $this->repository = $this->createMock(PostRepository::class);
        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->locationRepository = $this->createMock(LocationRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->creator = new PostCreator(
            $this->repository,
            new UserGetById($this->userRepository),
            new ForumGetBySlug($this->forumRepository),
            new AnimalGetById($this->animalRepository),
            new LocationGetById($this->locationRepository)
        );
        $this->animal = $this->createMock(Animal::class);
        $this->forum = $this->createMock(Forum::class);
        $this->user = $this->createMock(User::class);
        $this->location = $this->createMock(Location::class);
    }

    public function test__invoke(): void
    {
        $postTitle = "Test Post Title";
        $postContent = "This is a test post content";

        $this->locationRepository->expects($this->once())
            ->method('search')
            ->with($this->location->getId())
            ->willReturn($this->location);
        $this->animalRepository->expects($this->once())
            ->method('search')
            ->with($this->animal->getId())
            ->willReturn($this->animal);
        $this->forumRepository->expects($this->once())
            ->method('getBySlug')
            ->with($this->forum->getSlug())
            ->willReturn($this->forum);
        $this->userRepository->expects($this->once())
            ->method('search')
            ->with($this->user->getId())
            ->willReturn($this->user);
        $this->repository->expects($this->once())->method('save');

        $command = new CreatePostCommand(
            $postTitle,
            $postContent,
            $this->animal->getId(),
            $this->forum->getSlug(),
            $this->user->getId(),
            $this->location->getId()
        );
        $post = $this->creator->__invoke($command);

        $this->assertEquals($postTitle, $post->getTitle());
        $this->assertEquals($postContent, $post->getContent());
        $this->assertEquals($this->animal->getId(), $post->getAnimal()->getId());
        $this->assertEquals($this->forum->getName(), $post->getForum()->getName());
        $this->assertEquals($this->user->getName(), $post->getUser()->getName());
        $this->assertEquals($this->location->getId(), $post->getLocation()->getId());
    }

}
