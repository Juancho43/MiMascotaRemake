<?php
namespace App\MiMascota\Locations\Domain;

interface LocationRepository
{
    public function getAll(int $page = 1, int $limit = 10): array;
    public function save(Location $location): void;
    public function findById(string $id): ?Location;
    public function search(string $query): array;
    public function findByCords(string $latitude, string $longitude, string $city): ?Location;
    public function findBySlug(string $slug): ?Location;
    public function delete(Location $location): void;
}
