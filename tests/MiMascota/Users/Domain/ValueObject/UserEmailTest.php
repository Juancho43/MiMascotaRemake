<?php

namespace App\Tests\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use PHPUnit\Framework\TestCase;

class UserEmailTest extends TestCase
{

    public function testCreateUserEmailObject()
    {
        $email = 'api@api.com';
        $userEmail = UserEmail::create($email);

        $this->assertNotEmpty($userEmail->getValue());
        $this->assertNotEmpty($userEmail->getCode());
        $this->assertFalse($userEmail->isVerified());


    }
    public function testCreateUserEmailObjectFails()
    {
        $this->expectException(\Exception::class);
        $email = 'apiapi.com';
        UserEmail::create($email);
    }
    public function testGetEmail()
    {
        $email = 'api@api.com';
        $userEmail = UserEmail::create($email);
        $this->assertEquals($email, $userEmail->getValue());
    }
    public function testGetCode()
    {
        $email = 'api@api.com';
        $userEmail = UserEmail::create($email);
        $this->assertNotNull($email, $userEmail->getCode());
    }

    public function testVerifyCode()
    {
        $email = 'api@api.com';
        $userEmail = UserEmail::create($email);
        $code = $userEmail->getCode();
        $this->assertTrue($userEmail->verifyCode($code));

    }
    public function testVerifyCodeFails()
    {
        $this->expectException(\Exception::class);
        $email = 'api@api.com';
        $userEmail = UserEmail::create($email);
        $code = 'wrong_code';
        $this->assertFalse($userEmail->verifyCode($code));
        $this->assertNotEquals($userEmail->getCode(), $code);

    }

    public function testIsVerified()
    {
        $email = 'api@api.com';
        $userEmail = UserEmail::create($email);
        $code = $userEmail->getCode();
        $this->assertTrue($userEmail->verifyCode($code));
        $this->assertIsBool($userEmail->isVerified());
        $this->assertTrue($userEmail->isVerified());
    }

    public function testIsAlreadyVerified(){
        $email = 'api@api.com';
        $userEmail = UserEmail::create($email);
        $code = $userEmail->getCode();
        $userEmail->verifyCode($code);

        $this->assertTrue($userEmail->verifyCode($code));
    }
    public function testIsNotVerified()
    {
        $email = 'api@api.com';
        $userEmail = UserEmail::create($email);
        $this->assertFalse($userEmail->isVerified());
    }

    //Edge cases
    public function testCreateUserEmailObjectWithEmptyString()
    {
        $this->expectException(\Exception::class);
        UserEmail::create('');
    }


    public function testCreateUserEmailObjectWithWhitespace()
    {
        $this->expectException(\Exception::class);
        UserEmail::create('   ');
    }

    public function testCreateUserEmailObjectWithSpecialCharacters()
    {
        $this->expectException(\Exception::class);
        UserEmail::create('api@api!.com');
    }
}


