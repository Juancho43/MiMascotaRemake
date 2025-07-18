<?php

namespace App\MiMascota\Animals\Domain;

interface AnimalRepository
{
    public function search(string $id): ?Animal;
    public function searchByName(string $name): ?Animal;
    public function getAnimal(string $journalId): ?Animal;
    public function save(Animal $animal): void;
    public function getAnimals(string $userId): array;
    public function update(Animal $animal): void;
}
