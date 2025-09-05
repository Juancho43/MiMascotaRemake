<?php

namespace App\Tests\MiMascota\Posts\Application;

use App\MiMascota\Animals\Application\AnimalGetById;
use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Forums\Application\ForumGetBySlug;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Application\LocationGetById;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\Command\EditPostCommand;
use App\MiMascota\Posts\Application\PostCreator;
use App\MiMascota\Posts\Application\PostEdit;
use App\MiMascota\Posts\Application\PostGetById;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use App\Tests\MiMascota\Shared\PostMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostEditTest extends TestCase
{
    private PostEdit $postEdit;
    private PostRepository $postRepository;
    private LocationRepository $locationRepository;
    private AnimalRepository $animalRepository;
    private UserRepository $userRepository;

    private User $user;
    private Post $post;
    private Location $location;
    private Animal $animal;
    public function setUp(): void
    {


        $this->repository = $this->createMock(PostRepository::class);
        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->locationRepository = $this->createMock(LocationRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->postEdit= new PostEdit(
            $this->repository,
            new PostGetById($this->repository),
            new LocationGetById($this->locationRepository),
            new AnimalGetById($this->animalRepository),
            new UserGetById($this->userRepository),

        );
        $this->animal = $this->createMock(Animal::class);
        $this->forum = $this->createMock(Forum::class);
        $this->user = $this->createMock(User::class);
        $this->location = $this->createMock(Location::class);
        $this->post = PostMock::generate(
            Uuid::uuid4()->toString(),
            $this->forum,
            $this->user,
            $this->location,
            $this->animal
        );
    }

    public function test__invoke()
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->user);
        $this->repository->expects($this->once())
            ->method('search')
            ->willReturn($this->post);
        $this->locationRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->location);
        $this->animalRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->animal);
        $command = new EditPostCommand(
            $this->post->getId(),
            'Updated Title',
            'Updated Content',
            $this->location->getId(),
            $this->animal->getId(),
            $this->user->getId()
        );
        $response = $this->postEdit->__invoke($command);
        $this->assertEquals('Updated Title', $response->getTitle());
        $this->assertEquals('Updated Content', $response->getContent());
        $this->assertEquals($this->location->getId(), $response->getLocation()->getId());
        $this->assertEquals($this->animal->getId(), $response->getAnimal()->getId());
        $this->assertEquals($this->user->getName(), $response->getUser()->getName());
        $this->assertEquals($this->post->getId(), $response->getId());
    }

}
