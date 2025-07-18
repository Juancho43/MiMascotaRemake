<?php
namespace App\MiMascota\Animals\Application\DTO;

use App\MiMascota\Animals\Domain\Animal;
use DateTime;

class AnimalResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $color,
        public readonly string $size,
        public readonly string $breed,
        public readonly string $gender,
        public readonly DateTime $birthDate,
        public readonly float $weight,
        public readonly string $journalId,
        public readonly array $images = []
    ) {}

    public static function fromAnimal(Animal $animal): self
    {
        return new self(
            id: $animal->getId(),
            name: $animal->getName(),
            description: $animal->getDescription(),
            color: $animal->getColor(),
            size: $animal->getSize(),
            breed: $animal->getBreed(),
            gender: $animal->getGender(),
            birthDate: $animal->getBirthDate(),
            weight: $animal->getWeight(),
            journalId: $animal->getJournal()->getId(),
//            images: $animal->getImages()->map(fn($image) => [
//                'id' => $image->getId(),
//                'position' => $image->getPosition(),
//                // Añade más campos si necesitas
//            ])->toArray()
        );
    }
}
