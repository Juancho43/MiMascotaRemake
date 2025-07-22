<?php

namespace App\Tests\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use PHPUnit\Framework\TestCase;

class UserTelephoneTest extends TestCase
{

    public function testCreate()
    {
        $userTelephone = UserTelephone::create('+1234567890');
        $this->assertInstanceOf(UserTelephone::class, $userTelephone);
        $this->assertEquals('+1234567890', $userTelephone->getValue());
    }

    public function testCreateFailsWithInvalidLength()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserTelephone::create('123'); // Too short
    }
    public function testCreateFailsWithInvalidCharacters()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserTelephone::create('123-456'); // Contains invalid character '-'
    }
    public function testCreateFailsWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserTelephone::create(''); // Empty value
    }
}
