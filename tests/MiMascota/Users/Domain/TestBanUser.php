<?php

namespace App\Tests\MiMascota\Users\Domain;

use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Users\Domain\User;
use App\Tests\MiMascota\Shared\AnimalMock;
use App\Tests\MiMascota\Shared\ForumMock;
use App\Tests\MiMascota\Shared\LocationMock;
use App\Tests\MiMascota\Shared\PostMock;
use App\Tests\MiMascota\Shared\UserMock;
use Faker\Core\Uuid;
use PHPUnit\Framework\TestCase;

class TestBanUser extends TestCase
{

    private User $user;
    private Forum $forum;
    private Location $location;


    public function setUp(): void
    {
        parent::setUp();
        $this->user = UserMock::generate('12345');
        $this->forum = ForumMock::generate('1222');
        $this->location = LocationMock::generate('1111');
        $this->user->addPost(PostMock::generate('1233', $this->forum, $this->user, $this->location, AnimalMock::generate('222')));
        $this->user->addPost(PostMock::generate('1233', $this->forum, $this->user, $this->location, AnimalMock::generate('222')));
        $this->user->addPost(PostMock::generate('1233', $this->forum, $this->user, $this->location, AnimalMock::generate('222')));
        $this->user->addPost(PostMock::generate('1233', $this->forum, $this->user, $this->location, AnimalMock::generate('222')));

    }


    public function testBanUser()
    {
        //Arrange
            $posts = $this->user->getPosts()->toArray();
            $posts[0]->report();
            $posts[2]->report();
            $posts[3]->report();

        //Act

            $this->user->banUser();
        //Assert
            $this->assertNotNull($this->user->getSoftDelete()->getDeletedAt());


    }
    public function testBanUserNotEnoughReports()
    {
        //Arrange
        $posts = $this->user->getPosts()->toArray();
        $posts[0]->report();

        //Act
        $this->user->banUser();
        //Assert
        $this->assertNull($this->user->getSoftDelete()->getDeletedAt());
    }
}
