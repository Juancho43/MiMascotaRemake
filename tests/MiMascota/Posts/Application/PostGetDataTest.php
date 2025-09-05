<?php

namespace App\Tests\MiMascota\Posts\Application;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Posts\Application\PostGetById;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use App\Tests\MiMascota\Shared\PostMock;
use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostGetDataTest extends TestCase
{
    private PostGetById $getData;
    private PostRepository $postRepository;
    private Post $post;
    public function setUp(): void
    {

        $this->postRepository = $this->createMock(PostRepository::class);
        $this->getData = new PostGetById($this->postRepository);

        $this->user = UserMock::generate(Uuid::uuid4()->toString(), );
        $this->location = $this->createMock(Location::class);
        $this->animal = $this->createMock(Animal::class);
        $this->post = PostMock::generate(
            Uuid::uuid4()->toString(),
            $this->createMock(Forum::class),
            $this->user,
            $this->location,
            $this->animal,
        );

    }

    public function test__invoke(): void
    {

        $this->postRepository->expects($this->once())->method('search')
            ->with($this->post->getId())
            ->willReturn($this->post);

        $post = $this->getData->__invoke(new GetPostByIdQuery($this->post->getId()));

        $this->assertEquals($this->post->getId(), $post->getId());
        $this->assertEquals($this->post->getTitle(), $post->getTitle());
        $this->assertEquals($this->post->getSlug(), $post->getSlug());

    }

    public function test__invoke__fails()
    {
        $this->expectException(ModelNotFound::class);
        $this->postRepository->expects($this->once())->method('search')
            ->with('some-non-existing-id')
            ->willReturn(null);

        $this->getData->__invoke(new GetPostByIdQuery('some-non-existing-id'));
    }

}
