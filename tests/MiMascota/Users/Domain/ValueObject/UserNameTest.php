<?php

namespace App\Tests\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Shared\Domain\InvalidFormat;
use App\MiMascota\Shared\Domain\InvalidLength;
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



    public function testInvalidNameTooShort()
    {
        $this->expectException(InvalidLength::class);
        UserName::create('JD');
    }

    public function testInvalidNameTooLong()
    {
        $this->expectException(InvalidLength::class);
        UserName::create(str_repeat('a', 51)); // 51 characters long
    }

    public function testInvalidNameEmpty()
    {
        $this->expectException(InvalidLength::class);
        UserName::create(''); // Empty name
    }

    public function testInvalidNameInvalidCharacters()
    {
        $this->expectException(InvalidFormat::class);
        UserName::create('John@Doe'); // Contains invalid character '@'
    }

}
