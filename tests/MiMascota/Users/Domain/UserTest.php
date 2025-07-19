<?php

namespace App\Tests\MiMascota\Users\Domain;

use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testLogout(){
        $user = User::create(
            '12345',
            'John Doe',
            UserEmail::createNew("hola@m.com"),
            UserPassword::create('hola'),
        );
        $this->assertTrue($user->verifyCodeAndLogin($user->getValidationCode()));
        $this->assertTrue($user->logout());
    }

    public function testLogoutFails()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("User logout failed");
        $user = User::create(
            '12345',
            'John Doe',
            UserEmail::createNew("hola@s.com"),
            UserPassword::create('hola'),
            );
        $user->logout();
    }
    public function testVerifyCodeAndLogin()
    {
        $user = User::create(
            '12345',
            'John Doe',
            UserEmail::createNew("hola@m.com"),
            UserPassword::create('hola'),
        );
        $this->assertTrue($user->verifyCodeAndLogin($user->getValidationCode()));
        $this->assertNotNull($user->getToken());
    }


    public function testRemoveJournal()
    {
        $user = User::create(
            '12345',
            'John Doe',
            UserEmail::createNew("hola@m.com"),
            UserPassword::create('hola'),
        );
        $journal = $this->createMock(Journal::class);
        $user->addJournal($journal);
        $user->removeJournal($journal);
        $this->assertEquals(0, $user->getJournals()->count());
    }

    public function testLogin()
    {
        $user = User::create(
            '12345',
            'John Doe',
            UserEmail::createNew("hola@m.com"),
            UserPassword::create('hola'),
        );
        $user->getEmailObject()->verifyCode($user->getValidationCode());
        $this->assertNotNull($user->login('hola'));
        $this->assertNotNull($user->getToken());
    }

    public function testCreate()
    {
        $user = User::create(
            '12345',
            'John Doe',
            UserEmail::createNew("hola@m.com"),
            UserPassword::create('hola'),
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('12345', $user->getId());
    }

    public function testChangePassword()
    {
        $name = "Juan";
        $email = "Juan@mail.com";
        $oldPassword = "OldPassword123";
        $newPassword = "NewPassword123";
        // Crear usuario con contraseña antigua
        $user = User::create(
            '12345',
            $name,
            UserEmail::createNew($email),
            UserPassword::create($oldPassword)
        );
        $response = $user->changePassword($newPassword);

        $this->assertTrue($response);
        $this->assertTrue($user->getPassword()->verify($newPassword));
        $this->assertNull($user->getToken());

    }

    public function testAddJournal()
    {
        $user = User::create(
            '12345',
            'John Doe',
            UserEmail::createNew("hola@m.com"),
            UserPassword::create('hola'),
        );
        $journal = $this->createMock(Journal::class);
        $user->addJournal($journal);
        $userJournals = $user->getJournals();
        $this->assertInstanceOf(Journal::class, $userJournals->get(0));

    }
}
