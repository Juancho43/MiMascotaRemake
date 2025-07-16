<?php
namespace App\MiMascota\Locations\Domain;

interface LocationRepository
{
    public function save(Location $location): void;
    public function search(string $id): ?Location;
    public function findByCords(string $latitude, string $longitude, string $city): ?Location;
}
