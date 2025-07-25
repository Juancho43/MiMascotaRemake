<?php

namespace App\Tests\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Posts\Application\PostGetData;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostGetDataTest extends KernelTestCase
{
    private PostGetData $getData;
    private PostRepository $postRepository;
    private Post $post;
    public function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->postRepository = $this->createMock(PostRepository::class);
        $this->getData = new PostGetData($this->postRepository);

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

    public function test__invoke(): void
    {

        $this->postRepository->expects($this->once())->method('search')
            ->with($this->post->getId())
            ->willReturn($this->post);

        $post = $this->getData->__invoke($this->post->getId());

        $this->assertEquals($this->post->getId(), $post['id']);
        $this->assertEquals($this->post->getTitle(), $post['title']);
        $this->assertEquals($this->post->getSlug(), $post['slug']);

    }

    public function test__invoke__fails()
    {
        $this->expectException(ModelNotFound::class);
        $this->postRepository->expects($this->once())->method('search')
            ->with('some-non-existing-id')
            ->willReturn(null);

        $this->getData->__invoke('some-non-existing-id');
    }

}
