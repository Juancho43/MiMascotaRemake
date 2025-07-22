<?php

namespace App\Tests\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Users\Domain\ValueObject\UserPreference;
use PHPUnit\Framework\TestCase;

class UserPreferenceTest extends TestCase
{

    public function testCreate()
    {
        $userPreference = UserPreference::create(
            '12345',
            $this->createMock(\App\MiMascota\Users\Domain\User::class),
            'theme',
            'dark'
        );
        $this->assertInstanceOf(UserPreference::class, $userPreference);
        $this->assertEquals('12345', $userPreference->getId());
        $this->assertEquals('theme', $userPreference->getPreference());
        $this->assertEquals('dark', $userPreference->getValue());
    }

    public function testSetValue()
    {
        $userPreference = UserPreference::create(
            '12345',
            $this->createMock(\App\MiMascota\Users\Domain\User::class),
            'theme',
            'dark'
        );
        $userPreference->setValue('light');
        $this->assertNotEquals('dark', $userPreference->getValue());
        $this->assertEquals('light', $userPreference->getValue());
    }

    public function testCreateFailsWithEmptyId()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserPreference::create('', $this->createMock(\App\MiMascota\Users\Domain\User::class), 'theme', 'dark');
    }

    public function testCreateFailsWithEmptyPreference()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserPreference::create('12345', $this->createMock(\App\MiMascota\Users\Domain\User::class), '', 'dark');
    }
    public function testCreateFailsWithInvalidUser()
    {
        $this->expectException(\TypeError::class);
        UserPreference::create('12345', new \stdClass(), 'theme', 'dark');
    }

    public function testCreateFailsWithInvalidPreferenceLength()
    {
        $this->expectException(\InvalidArgumentException::class);
        UserPreference::create('12345', $this->createMock(\App\MiMascota\Users\Domain\User::class), 'th', 'dark');
    }
}
