<?php

namespace App\Tests\MiMascota\Users\Domain;

use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\UserImage;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        $this->user = $this->generateMockUser('12345', 'John Doe', '1234567890', 'email@mail.com', 'password123');
    }
    private function generateMockUser($id, $name, $telephone, $email, $password)
    {
        return User::create(
            $id,
            UserName::create($name),
            UserTelephone::create($telephone),
            UserEmail::create($email),
            UserPassword::create($password)
        );
    }

    public function testCreate()
    {
        $this->assertInstanceOf(User::class, $this->user);
        $this->assertEquals('12345', $this->user->getId());
    }
    public function testAddJournal()
    {
        $journal = $this->createMock(Journal::class);
        $this->user->addJournal($journal);
        $userJournals = $this->user->getJournals();
        $this->assertInstanceOf(Journal::class, $userJournals->get(0));

    }
    public function testRemoveJournal()
    {

        $journal = $this->createMock(Journal::class);
        $this->user->addJournal($journal);
        $this->user->removeJournal($journal);
        $this->assertEquals(0, $this->user->getJournals()->count());
    }
    public function testChangeName()
    {
        $this->user->rename('Hola');
        $this->assertEquals('Hola', $this->user->getName());
        $this->assertNotEquals($this->user->getName(),'John Doe');
    }
    public function testChangePassword()
    {
        $name = "Juan";
        $email = "Juan@mail.com";
        $oldPassword = "OldPassword123";
        $newPassword = "NewPassword123";
        // Crear usuario con contraseña antigua
        $user = $this->generateMockUser('12', $name, '1234567890', $email, $oldPassword);
        $response = $user->changePassword($newPassword);

        $this->assertTrue($response);
        $this->assertTrue($user->getPassword()->verify($newPassword));
        $this->assertCount(0,$user->getTokens());

    }
    public function testUserCanPost()
    {
        $this->user->addPost($this->createMock(\App\MiMascota\Posts\Domain\Post::class));
        $this->assertCount(1, $this->user->getPosts());
    }
    public function testUserCanDeletePost()
    {
        $post = $this->createMock(\App\MiMascota\Posts\Domain\Post::class);
        $this->user->addPost($post);
        $this->user->removePost($post);
        $this->assertCount(0, $this->user->getPosts());
    }
    public function testUserCanEditPost()
    {
        $post = $this->createMock(\App\MiMascota\Posts\Domain\Post::class);
        $this->user->addPost($post);
        $post->edit('New Title', 'New Content');
        $this->assertCount(1, $this->user->getPosts());
    }
    public function testUserCanHaveImage()
    {
        $userImage = UserImage::create('11111',$this->user,$this->createMock(Image::class));
        $this->user->setImage($userImage);
        $this->assertEquals($userImage,$this->user->getImage());
    }

    public function testUserHasMultiplesPreferences()
    {
        $preference1 = $this->user->addPreference('1111','preference1','value1');
        $preference2 =$this->user->addPreference('11111','preference2','value2');
        $preferences = $this->user->getPreferences();
        $this->assertCount(2, $preferences);
        $this->assertContains($preference1, $preferences);
        $this->assertContains($preference2, $preferences);
    }
    public function testUserCanDeletePreferences()
    {
        $preference = $this->user->addPreference('1222','preference1', 'value1');
        $this->user->addPreference('12222','preference2', 'value2');
        $this->user->removePreference($preference);
        $preferences = $this->user->getPreferences();
        $this->assertCount(1, $preferences);
    }
    public function testUserGetPreference()
    {
        $preference = $this->user->addPreference('1222','preference1', 'value1');
        $this->assertEquals($preference, $this->user->getPreference('preference1'));

    }

}
