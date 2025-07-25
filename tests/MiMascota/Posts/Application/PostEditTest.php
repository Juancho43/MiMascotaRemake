<?php

namespace App\Tests\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Animals\Domain\AnimalRepository;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Posts\Application\PostEdit;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostEditTest extends KernelTestCase
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
        self::bootKernel();
        parent::setUp();
        $this->postRepository = $this->createMock(PostRepository::class);
        $this->locationRepository = $this->createMock(LocationRepository::class);
        $this->animalRepository = $this->createMock(AnimalRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->postEdit = new PostEdit(
            $this->postRepository,
            $this->locationRepository,
            $this->animalRepository,
            $this->userRepository
        );

        $this->user = User::create(
            '1111',
            UserName::create('Hola User'),
            UserTelephone::create('1234567890'),
            UserEmail::create('hola@mail.com'),
            UserPassword::create('password123')
            )
            ;
        $this->location = $this->createMock(Location::class);
        $this->animal = $this->createMock(Animal::class);
        $this->post = Post::create(
            '1111',
            'Hola',
            SlugGenerator::generate('Hola'),
            'Contenido del post',
            $this->createMock(Forum::class),
            $this->user,
            $this->animal,
            $this->location
        );

    }

    public function test__invoke()
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->user);
        $this->postRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->post);
        $this->locationRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->location);
        $this->animalRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->animal);
        $response = $this->postEdit->__invoke(
            $this->post->getId(),
            'Updated Title',
            'Updated Content',
            $this->location->getId(),
            $this->animal->getId(),
            $this->user->getId()
        );
        $this->assertEquals('Updated Title', $response['title']);
        $this->assertEquals('Updated Content', $response['content']);
        $this->assertEquals($this->location->getId(), $response['location']['id']);
        $this->assertEquals($this->animal->getId(), $response['animal']['id']);
        $this->assertEquals($this->user->getName(), $response['user']);
    }

    public function test__invokeFailsWithInvalidUser()
    {   $this->expectException(UserPermissionDenied::class);
        $user = User::create(
            '11122',
            UserName::create('Hola User'),
            UserTelephone::create('1234567890'),
            UserEmail::create('hola@mail.com'),
            UserPassword::create('password123')
        )
        ;

        $this->userRepository->expects($this->once())
            ->method('search')
            ->willReturn($user);
        $this->postRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->post);


        $this->postEdit->__invoke(
            $this->post->getId(),
            'Updated Title',
            'Updated Content',
            $this->location->getId(),
            $this->animal->getId(),
            $user->getId()
        );
    }
    public function test__invokeFailsWithPostNotFound()
    {
        $this->expectException(ModelNotFound::class);

        $this->postRepository->expects($this->once())
            ->method('search')
            ->willReturn(null);

        $this->postEdit->__invoke(
            'non-existing-post-id',
            'Updated Title',
            'Updated Content',
            $this->location->getId(),
            $this->animal->getId(),
            $this->user->getId()
        );
    }
    public function test__invokeFailsWithLocationNotFound()
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->user);
        $this->postRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->post);
        $this->expectException(ModelNotFound::class);

        $this->locationRepository->expects($this->once())
            ->method('search')
            ->willReturn(null);

        $this->postEdit->__invoke(
            $this->post->getId(),
            'Updated Title',
            'Updated Content',
            'non-existing-location-id',
            $this->animal->getId(),
            $this->user->getId()
        );
    }
    public function test__invokeFailsWithAnimalNotFound()
    {
        $this->userRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->user);
        $this->postRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->post);
        $this->locationRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->location);
        $this->expectException(ModelNotFound::class);

        $this->animalRepository->expects($this->once())
            ->method('search')
            ->willReturn(null);

        $this->postEdit->__invoke(
            $this->post->getId(),
            'Updated Title',
            'Updated Content',
            $this->location->getId(),
            'non-existing-animal-id',
            $this->user->getId()
        );
    }
    public function test__invokeFailsWithUserNotFound()
    {
        $this->expectException(ModelNotFound::class);
        $this->userRepository->expects($this->once())
            ->method('search')
            ->willReturn(null);
        $this->postRepository->expects($this->once())
            ->method('search')
            ->willReturn($this->post);
        $this->postEdit->__invoke(
            $this->post->getId(),
            'Updated Title',
            'Updated Content',
            $this->location->getId(),
            'non-existing-animal-id',
            '9'
        );
    }
}
