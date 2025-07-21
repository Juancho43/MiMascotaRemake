<?php

namespace App\Tests\MiMascota\Users\Application;


use App\MiMascota\Locations\Application\LocationManager;
use App\MiMascota\Locations\Domain\UserLocation;
use App\MiMascota\Users\Application\UserRegister;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class UserRegisterTest extends KernelTestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = static::getContainer();
        $repository = $this->createMock(UserRepository::class);
        $this->container->set(UserRepository::class, $repository);
        $locationManager = $this->createMock(LocationManager::class);
        $this->container->set(LocationManager::class, $locationManager);
    }

    public function test__invoke()
    {
        //Arrange
        $name = "Juan";
        $email= "Juan@mail.com";
        $telephone = "123456789";
        $password = "Pepe";
        $latitude = "-34.61258";
        $longitude = '-58.38156';
        $UserRegister = $this->container->get(UserRegister::class);
        //Act
        $user = $UserRegister->__invoke($name, $telephone, $email, $password, $latitude, $longitude);
        //Assert
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($telephone, $user->getTelephone());
        $this->assertNotEmpty($user->getPassword()->getValue());
        $this->assertNotNull($user->getValidationCode());
        $this->assertInstanceOf(UserLocation::class,$user->getUserLocation());

    }
    public function test__invokeWithInvalidEmail()
    {
        $this->expectException(\Exception::class);
        $name = "Juan";
        $email= "Juanmail.com";
        $telephone = "123456789";
        $password = "Pepe";
        $latitude = "-34.61258";
        $longitude = '-58.38156';
        $UserRegister = $this->container->get(UserRegister::class);
        //Act
        $UserRegister->__invoke($name, $telephone, $email, $password, $latitude, $longitude);

    }
}
