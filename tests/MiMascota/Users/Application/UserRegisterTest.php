<?php

namespace App\Tests\MiMascota\Users\Application;


use App\MiMascota\Locations\Application\LocationCreator;
use App\MiMascota\Locations\Application\SaveLocation;
use App\MiMascota\Locations\Application\LocationGetByCords;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Locations\Domain\LocationResolver;
use App\MiMascota\Locations\Domain\UserLocation;
use App\MiMascota\Locations\Domain\ValueObject\LocationCity;
use App\MiMascota\Locations\Domain\ValueObject\LocationCountry;
use App\MiMascota\Locations\Domain\ValueObject\LocationLatitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationLongitude;
use App\MiMascota\Locations\Infrastructure\ReverseGeocodeClient;
use App\MiMascota\Users\Application\Command\CreateUserCommand;
use App\MiMascota\Users\Application\UserRegister;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class UserRegisterTest extends TestCase
{
    private UserRegister $userRegister;
    private UserRepository $userRepository;
    private LocationResolver $locationManager;

    protected function setUp(): void
    {
        parent::setUp();
        // 1. Mockea las dependencias directas
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->locationManager = $this->createMock(LocationResolver::class);

        // 2. Inyecta los mocks en la clase a testear
        $this->userRegister = new UserRegister(
            $this->userRepository,
            $this->locationManager
        );
    }


    public function test__invoke()
    {
        //Arrange
        $name = "Juan";
        $email= "Juan@mail.com";
        $telephone = "123456789";
        $password = "Pepe";
        $role = "user";
        $latitude = "-34.612";
        $longitude = '-58.381';
        $command = new CreateUserCommand(
            $name,
            $telephone,
            $email,
            $password,
            $role,
            $latitude,
            $longitude
        );
        $location = Location::create(
            'location-id',
            LocationCity::create('Buenos Aires'),
            LocationCountry::create('Argentina'),
            LocationLatitude::create($latitude),
            LocationLongitude::create($longitude)
        );
        $this->locationManager->expects($this->once())
            ->method('getLocation')
            ->with($latitude, $longitude)
            ->willReturn($location);

        //Act

        $user = $this->userRegister->__invoke($command);
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
        $command = new CreateUserCommand(
            $name,
            $telephone,
            $email,
            $password,
            'user',
            $latitude,
            $longitude
        );
        //Act
        $this->userRegister->__invoke($command);

    }
}
