<?php

namespace App\Tests\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Application\ForumSoftDelete;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Posts\Application\Command\DeletePostCommand;
use App\MiMascota\Posts\Application\PostGetById;
use App\MiMascota\Posts\Application\PostSoftDelete;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\ForumMock;
use App\Tests\MiMascota\Shared\LocationMock;
use App\Tests\MiMascota\Shared\PostMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostSoftDeleteTest extends TestCase
{


    private PostSoftDelete $postSoftDelete;
    private PostRepository $postRepository;

    public function setUp(): void
    {

        parent::setUp();
        $this->postRepository = $this->createMock(PostRepository::class);
        $this->postSoftDelete = new PostSoftDelete($this->postRepository, new PostGetById($this->postRepository));
    }
    public function test__invoke()
    {
        $post = PostMock::generate(
            '1111',
            ForumMock::generate(Uuid::uuid4()->toString()),
            UserMock::generate(Uuid::uuid4()->toString()),
            LocationMock::generate(Uuid::uuid4()->toString()),
            AnimalMock::generate(Uuid::uuid4()->toString()),

        );


        $this->postRepository->expects($this->once())->method('search')->with($post->getId())->willReturn($post);
        $this->postRepository->expects($this->once())->method('save');

        $forum = $this->postSoftDelete->__invoke(new DeletePostCommand($post->getId()));

        $this->assertTrue($forum->getSoftDelete()->isDeleted());

    }

    public function test_invokeFails()
    {
        $this->expectException(ModelNotFound::class);

        $postId = Uuid::uuid4()->toString();
        $this->postRepository->expects($this->once())->method('search')->with($postId)->willReturn(null);

        $this->postSoftDelete->__invoke(new DeletePostCommand($postId));
    }
}
