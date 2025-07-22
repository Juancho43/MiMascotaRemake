<?php

namespace App\Tests\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\ValueObject\UserName;
use PHPUnit\Framework\TestCase;

class UserNameTest extends TestCase
{

    public function testCreate()
    {
        $userName = UserName::create('John Doe');
        $this->assertInstanceOf(UserName::class, $userName);
        $this->assertEquals('John Doe', $userName->getValue());
    }

    public function testRename()
    {
        $userName = UserName::create('John Doe');
        $newName = 'Jane Doe';
        $renamedUserName = $userName->rename($newName);
        $this->assertEquals('Jane Doe', $renamedUserName);
        $this->assertNotEquals('John Doe', $userName->getValue());
    }

    public function testInvalidNameTooShort()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserName::create('JD');
    }

    public function testInvalidNameTooLong()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserName::create(str_repeat('a', 51)); // 51 characters long
    }

    public function testInvalidNameEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserName::create(''); // Empty name
    }

    public function testInvalidNameInvalidCharacters()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserName::create('John@Doe'); // Contains invalid character '@'
    }

}
