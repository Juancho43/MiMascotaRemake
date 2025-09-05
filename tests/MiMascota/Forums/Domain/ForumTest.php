<?php

namespace App\Tests\MiMascota\Forums\Domain;

use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ValueObject\ForumDescription;
use App\MiMascota\Forums\Domain\ValueObject\ForumName;
use App\MiMascota\Forums\Domain\ValueObject\ForumSlug;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Shared\Domain\InvalidLength;
use App\Tests\MiMascota\Shared\ForumMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ForumTest extends TestCase
{

    private Forum $forum;

    public function setUp(): void
    {
        $this->forum =ForumMock::generate(Uuid::uuid4()->toString(), 'Test Forum',  'This is a test forum');
    }



    public function testCreate()
    {
        $this->assertInstanceOf(Forum::class, $this->forum);
        $this->assertEquals('Test Forum', $this->forum->getName());
        $this->assertEquals('test-forum', $this->forum->getSlug());
        $this->assertEquals('This is a test forum', $this->forum->getDescription());
    }
    public function testDelete(){
        $this->forum->delete();
        $this->assertTrue($this->forum->getSoftDelete()->isDeleted());
    }

    public function testUpdate(){
        $this->forum->setName(ForumName::create('Updated Forum'));
        $this->forum->setSlug(ForumSlug::create('updated-forum'));
        $this->forum->setDescription(ForumDescription::create('This is an updated forum'));

        $this->assertEquals('Updated Forum', $this->forum->getName());
        $this->assertEquals('updated-forum', $this->forum->getSlug());
        $this->assertEquals('This is an updated forum', $this->forum->getDescription());
    }

    public function testAddPost()
    {
        $this->forum->addPost($this->createMock(Post::class));
        $this->assertCount(1, $this->forum->getPosts());
    }

    public function testGetPosts()
    {
        $post = $this->createMock(Post::class);
        $this->forum->addPost($post);
        $this->assertTrue($this->forum->getPosts()->contains($post));
    }

    public function testDeletePost()
    {
        $post = $this->createMock(Post::class);
        $this->forum->addPost($post);
        $this->forum->deletePost($post);
        $this->assertFalse($this->forum->getPosts()->contains($post));
    }

public function testCreateWithEmptyId()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Forum ID cannot be empty.');

        ForumMock::generate('', 'Test Forum', 'This is a test forum');
    }


}
