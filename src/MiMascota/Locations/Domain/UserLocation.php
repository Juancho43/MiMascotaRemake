<?php
namespace App\MiMascota\Locations\Domain;
use App\MiMascota\Users\Domain\User;

class UserLocation
{
    private readonly string $id;
    private User $user;
    private Location $location;


    private function __construct(string $id, User $user, Location $location)
    {
        $this->id = $id;
        $this->user = $user;
        $this->location = $location;
    }

    public static function create(string $id, User $user, Location $location): self
    {
        return new self($id, $user, $location);
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }




}
