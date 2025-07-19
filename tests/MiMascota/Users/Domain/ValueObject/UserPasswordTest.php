<?php

namespace App\Tests\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use PHPUnit\Framework\TestCase;

class UserPasswordTest extends TestCase
{
    private string $password = 'password123';

    public function testGetValue()
    {
        $userPassword = UserPassword::create($this->password);
        $hashedPassword = $userPassword->getValue();

        $this->assertNotEmpty($hashedPassword);
        $this->assertNotEquals($this->password, $hashedPassword);
        $this->assertTrue(password_verify($this->password, $hashedPassword));
    }

    public function testCreateFails()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Password cannot be empty');
        UserPassword::create('');
    }

    public function testCreate()
    {
        $userPassword = UserPassword::create($this->password);
        $this->assertNotEmpty($userPassword->getValue());
    }

    public function testChange()
    {
        $userPassword = UserPassword::create($this->password);
        $newPassword = 'newpassword456';
        $oldPasswordHash = $userPassword->getValue();
        $userPassword->change($newPassword);
        $newPasswordHash = $userPassword->getValue();
        $this->assertNotEquals($newPasswordHash, $oldPasswordHash);
        $this->assertTrue(password_verify($newPassword, $newPasswordHash));
        $this->assertFalse(password_verify($this->password, $newPasswordHash));
    }
    public function testChangeFails()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error changing password: Error generating password hash: Password cannot be empty');
        $userPassword = UserPassword::create($this->password);
        $userPassword->change('');

    }

    public function testVerify()
    {
        $userPassword = UserPassword::create($this->password);
        $this->assertTrue($userPassword->verify($this->password));
    }
    public function testVerifyFails()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Password is not valid');
        $userPassword = UserPassword::create($this->password);
        $this->assertFalse($userPassword->verify('wrongpassword'));
    }
    //Edge cases
    public function testCreateWithWhitespaceOnly()
    {
        $this->expectException(\Exception::class);
        UserPassword::create('    ');
    }

    public function testCreateWithSpecialCharacters()
    {
        $password = '!@#$%^&*()_+-=';
        $userPassword = UserPassword::create($password);
        $this->assertTrue($userPassword->verify($password));
    }

    public function testCreateWithUnicodeCharacters()
    {
        $password = 'pässwörd😊';
        $userPassword = UserPassword::create($password);
        $this->assertTrue($userPassword->verify($password));
    }

    public function testCreateWithLongPassword()
    {
        $password = str_repeat('a', 1024);
        $userPassword = UserPassword::create($password);
        $this->assertTrue($userPassword->verify($password));
    }

    public function testCreateWithHashLikePassword()
    {
        $password = '$2y$10$abcdefghijklmnopqrstuv';
        $userPassword = UserPassword::create($password);
        $this->assertTrue($userPassword->verify($password));
    }

    public function testVerifyWithNull()
    {
        $this->expectException(\TypeError::class);
        $password = UserPassword::create($this->password);
        $password->verify(null);
    }

    public function testVerifyWithNonString()
    {
        $this->expectException(\TypeError::class);
        $userPassword = UserPassword::create($this->password);
        $this->assertFalse($userPassword->verify(['not', 'a', 'string']));
    }
}
