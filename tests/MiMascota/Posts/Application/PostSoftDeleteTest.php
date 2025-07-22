<?php

namespace App\Tests\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Application\ForumSoftDelete;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Posts\Application\PostSoftDelete;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostSoftDeleteTest extends KernelTestCase
{


    private PostSoftDelete $postSoftDelete;
    private PostRepository $postRepository;

    public function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->postRepository = $this->createMock(PostRepository::class);
        $this->postSoftDelete = new PostSoftDelete($this->postRepository);
    }
    public function test__invoke()
    {
        $post = Post::create(
            '1111',
            'Hola',
            SlugGenerator::generate('Hola'),
            'Contenido del post',
            $this->createMock(Forum::class),
            $this->createMock(User::class),
            $this->createMock(Animal::class),
            $this->createMock(Location::class),
        );


        $this->postRepository->expects($this->once())->method('search')->with($post->getId())->willReturn($post);
        $this->postRepository->expects($this->once())->method('save');

        $forum = $this->postSoftDelete->__invoke($post->getId());

        $this->assertInstanceOf(Post::class, $forum);
        $this->assertTrue($forum->getSoftDelete()->isDeleted());

    }

    public function test_invokeFails()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Post not found');

        $postId = Uuid::uuid4()->toString();
        $this->postRepository->expects($this->once())->method('search')->with($postId)->willReturn(null);

        $this->postSoftDelete->__invoke($postId);
    }
}
