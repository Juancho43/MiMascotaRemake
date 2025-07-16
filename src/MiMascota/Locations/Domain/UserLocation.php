<?php
namespace App\MiMascota\Locations\Domain;
use App\MiMascota\Users\Domain\User;

class UserLocation
{
    private string $id;
    private User $user;
    private Location $location;


    public function __construct(string $id, User $user, Location $location)
    {
        $this->id = $id;
        $this->user = $user;
        $this->location = $location;
    }
}
