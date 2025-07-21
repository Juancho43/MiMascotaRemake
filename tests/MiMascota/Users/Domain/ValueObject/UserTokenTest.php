<?php

namespace App\Tests\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserToken;
use PHPUnit\Framework\TestCase;

class UserTokenTest extends TestCase
{

    public function testGetValue()
    {
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $this->assertNotNull($token->getValue());
        $this->assertIsString($token->getValue());
        $this->assertEquals(64, strlen($token->getValue())); // 16 bytes hex
    }

    public function testReset()
    {
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $token->reset();
        $this->assertNull($token->getValue());
        $this->assertNull($token->getCreatedAt());
        $this->assertNull($token->getExpireAt());
    }

    public function testCheckExpired()
    {
        $this->expectException(\Exception::class);
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $token->reset();
        $this->assertFalse($token->checkExpired());
    }
    public function testGenerate()
    {
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $this->assertInstanceOf(UserToken::class, $token);
        $this->assertNotNull($token->getValue());
        $this->assertNotNull($token->getCreatedAt());
        $this->assertNotNull($token->getExpireAt());
        $this->assertNotTrue($token->checkExpired());
    }
    public function testGetCreatedAt()
    {
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $this->assertInstanceOf(\DateTime::class, $token->getCreatedAt());
        $this->assertLessThanOrEqual(new \DateTime(), $token->getCreatedAt());
    }

    public function testGetExpireAt()
    {
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $this->assertInstanceOf(\DateTime::class, $token->getExpireAt());
        $this->assertGreaterThanOrEqual(new \DateTime(), $token->getExpireAt());
        $this->assertEquals($token->getCreatedAt()->modify('+7 days')->getTimestamp(), $token->getExpireAt()->getTimestamp());
    }

    public function testCheckExpireWithHardcodeDate()
    {
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $date = (new \DateTime())->modify('+2 days')->format('Y-m-d H:i:s');
        $this->assertNotNull($token->checkExpired($date));

    }
    public function testCheckExpireWithHardcodeDateFails()
    {
        $this->expectException(\Exception::class);
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $date = (new \DateTime())->modify('+8 days')->format('Y-m-d H:i:s');
        $token->checkExpired($date);

    }

    public function testChangesExpiredDateWhenTokenIsValid()
    {
        $user = $this->createMock(User::class);
        $token = UserToken::generate('1234', $user);
        $expireAt = clone $token->getExpireAt();
        $this->assertNotNull($token->checkExpired('+2 days'));
        $this->assertNotEquals($expireAt->format('Y-m-d'), $token->getExpireAt()->format('Y-m-d'));


    }

    public function testCreateWithIpAndUserAgent(){
        $user = $this->createMock(User::class);
        $ip = '127.0.0.1';
        $agent = 'Mozilla/5.0';
        $token = UserToken::generate('1234', $user,$ip,$agent);
        $this->assertInstanceOf(UserToken::class, $token);
        $this->assertEquals($ip,$token->getIpAddress());
        $this->assertEquals($agent,$token->getUserAgent());
    }

    public function testIpValid(){
        $user = $this->createMock(User::class);
        $ip = '127.0.0.1';
        $agent = 'Mozilla/5.0';
        $token = UserToken::generate('1234', $user,$ip,$agent);
        $this->assertTrue($token->isValidForIP($ip));
    }

    public function testCheckValidIp()
    {
        $user = $this->createMock(User::class);
        $ip = '127.0.0.1';
        $agent = 'Mozilla/5.0';
        $token = UserToken::generate('1234', $user,$ip,$agent);
        $this->assertEquals($token->getValue(),$token->validateWithIP($ip));
    }
    public function testCheckValidIpFails()
    {
        $this->expectException(\Exception::class);
        $user = $this->createMock(User::class);
        $ip = '127.0.0.2';
        $agent = 'Mozilla/5.0';
        $token = UserToken::generate('1234', $user,$ip,$agent);
        $this->assertFalse($token->validateWithIP('127.0.0.1'));
    }
}
