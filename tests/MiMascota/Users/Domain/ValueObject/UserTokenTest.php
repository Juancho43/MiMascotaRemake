<?php

namespace App\Tests\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\ValueObject\UserToken;
use PHPUnit\Framework\TestCase;

class UserTokenTest extends TestCase
{

    public function testGetValue()
    {
        $token = UserToken::generate();
        $this->assertNotNull($token->getValue());
        $this->assertIsString($token->getValue());
        $this->assertEquals(32, strlen($token->getValue())); // 16 bytes hex
    }

    public function testReset()
    {
        $token = UserToken::generate();
        $token->reset();
        $this->assertNull($token->getValue());
        $this->assertNull($token->getCreatedAt());
        $this->assertNull($token->getExpireAt());
    }

    public function testIsExpired()
    {
        $token = UserToken::generate();
        $this->assertFalse($token->isExpired());
        $this->assertNotNull($token->getExpireAt());
    }

    public function testCheckExpired()
    {
        $this->expectException(\Exception::class);
        $token = UserToken::generate();
        $token->reset();
        $this->assertTrue($token->isExpired());
        $token->checkExpired();
    }
    public function testGenerate()
    {
        $token = UserToken::generate();
        $this->assertInstanceOf(UserToken::class, $token);
        $this->assertNotNull($token->getValue());
        $this->assertNotNull($token->getCreatedAt());
        $this->assertNotNull($token->getExpireAt());
        $this->assertNotTrue($token->isExpired());
    }
    public function testGetCreatedAt()
    {
        $token = UserToken::generate();
        $this->assertInstanceOf(\DateTime::class, $token->getCreatedAt());
        $this->assertLessThanOrEqual(new \DateTime(), $token->getCreatedAt());
    }

    public function testGetExpireAt()
    {
        $token = UserToken::generate();
        $this->assertInstanceOf(\DateTime::class, $token->getExpireAt());
        $this->assertGreaterThanOrEqual(new \DateTime(), $token->getExpireAt());
        $this->assertEquals($token->getCreatedAt()->modify('+7 days')->getTimestamp(), $token->getExpireAt()->getTimestamp());
    }
}
