<?php

namespace App\Tests\MiMascota\Users\Domain;

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
            UserEmail::createNew($email),
            UserPassword::create($password)
        );
    }

    public function testLogout(){
        $this->assertTrue($this->user->verifyCodeAndLogin($this->user->getValidationCode()));
        $this->assertTrue($this->user->logout());
    }

    public function testLogoutFails()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("User logout failed");
        $this->user->logout();
    }
    public function testVerifyCodeAndLogin()
    {

        $this->assertTrue($this->user->verifyCodeAndLogin($this->user->getValidationCode()));
        $this->assertNotNull($this->user->getToken());
    }


    public function testRemoveJournal()
    {

        $journal = $this->createMock(Journal::class);
        $this->user->addJournal($journal);
        $this->user->removeJournal($journal);
        $this->assertEquals(0, $this->user->getJournals()->count());
    }

    public function testLogin()
    {
        $this->user->getEmailObject()->verifyCode($this->user->getValidationCode());
        $this->assertNotNull($this->user->login('password123'));
        $this->assertNotNull($this->user->getToken());
    }

    public function testCreate()
    {
        $this->assertInstanceOf(User::class, $this->user);
        $this->assertEquals('12345', $this->user->getId());
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
        $this->assertCount(0,$user->getToken());

    }

    public function testAddJournal()
    {
        $journal = $this->createMock(Journal::class);
        $this->user->addJournal($journal);
        $userJournals = $this->user->getJournals();
        $this->assertInstanceOf(Journal::class, $userJournals->get(0));

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

    public function testUserCanEditPost(){
        $post = $this->createMock(\App\MiMascota\Posts\Domain\Post::class);
        $this->user->addPost($post);
        $post->edit('New Title', 'New Content');
        $this->assertCount(1, $this->user->getPosts());
    }
}
