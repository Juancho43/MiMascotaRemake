<?php

namespace App\Tests\MiMascota\Posts\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Users\Domain\User;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{

    private Post $post;
    public function setUp(): void
    {
        $this->post = $this->generatePost(
            '123e4567-e89b-12d3-a456-426614174000',
            'Test Post Title',
            'test-post-title',
            'This is the content of the test post.',
            $this->createMock(Forum::class),
            $this->createMock(User::class),
            $this->createMock(Animal::class),
            $this->createMock(Location::class)
        );
    }
    private function generatePost($id, $title, $slug,$content,$forum,$user,$animal,$location): Post
    {
        return Post::create(
            $id,
            $title,
            $slug,
            $content,
            $forum,
            $user,
            $animal,
            $location
        );
    }

    public function testCreate()
    {
        $this->assertInstanceOf(Post::class, $this->post);
        $this->assertEquals('Test Post Title', $this->post->getTitle());
        $this->assertEquals('test-post-title', $this->post->getSlug());
        $this->assertEquals('This is the content of the test post.', $this->post->getContent());
        $this->assertInstanceOf(Forum::class, $this->post->getForum());
        $this->assertInstanceOf(User::class, $this->post->getUser());
        $this->assertInstanceOf(Animal::class, $this->post->getAnimal());
        $this->assertInstanceOf(Location::class, $this->post->getLocation());

    }

    public function testEdit()
    {
        $newTitle = 'Updated Post Title';
        $newContent = 'This is the updated content of the test post.';
        $this->post->edit($newTitle, $newContent);
        $this->assertEquals($newTitle, $this->post->getTitle());
        $this->assertEquals($newContent, $this->post->getContent());
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
