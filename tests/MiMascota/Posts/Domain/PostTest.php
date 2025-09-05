<?php

namespace App\Tests\MiMascota\Posts\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\ForumMock;
use App\Tests\MiMascota\Shared\LocationMock;
use App\Tests\MiMascota\Shared\PostMock;

use App\Tests\MiMascota\Shared\UserMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PostTest extends TestCase
{

    private Post $post;
    public function setUp(): void
    {

        $this->post = PostMock::generate(
            Uuid::uuid4()->toString(),
            ForumMock::generate(Uuid::uuid4()->toString()),
            UserMock::generate(Uuid::uuid4()->toString()),
            LocationMock::generate(Uuid::uuid4()->toString()),
            AnimalMock::generate(Uuid::uuid4()->toString()),
        );
    }


    public function testCreate()
    {

        $this->assertEquals('prueba', $this->post->getTitle());
        $this->assertEquals('prueba', $this->post->getSlug());
        $this->assertEquals('contenido de prueba', $this->post->getContent());
        $this->assertInstanceOf(Forum::class, $this->post->getForum());
        $this->assertInstanceOf(User::class, $this->post->getUser());
        $this->assertInstanceOf(Animal::class, $this->post->getAnimal());
        $this->assertInstanceOf(Location::class, $this->post->getLocation());

    }



    public function testDelete()
    {
        $this->post->delete();
        $this->assertTrue($this->post->getSoftDelete()->isDeleted());
    }

    public function testGetAnimal()
    {
        $this->assertInstanceOf(Animal::class, $this->post->getAnimal());
    }

    public function testGetLocation()
    {
        $this->assertInstanceOf(Location::class, $this->post->getLocation());
    }
    public function testGetForum()
    {
        $this->assertInstanceOf(Forum::class, $this->post->getForum());
    }
    public function testGetUser()
    {
        $this->assertInstanceOf(User::class, $this->post->getUser());
    }
}
