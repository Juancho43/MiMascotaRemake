<?php

namespace App\MiMascota\Animals\Domain;

use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Animal
{
    private Journal $journal;

    /**
     * @var Collection<int, AnimalImage>
     */
    private Collection $images;

    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;

    private function __construct(
        private readonly string $id,
        private string $name,
        private string $description,
        private string $color,
        private string $size,
        private string $breed,
        private string $gender,
        private DateTime $birthDate,
        private float $weight,
    ) {
        $this->images = new ArrayCollection();
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
    }

    public static function create(
        string $id,
        string $name,
        string $description,
        string $color,
        string $size,
        string $breed,
        string $gender,
        DateTime $birthDate,
        float $weight
    ) {
        return new self($id, $name, $description, $color, $size, $breed, $gender, $birthDate, $weight);
    }

    public function getJournal(): Journal
    {
        return $this->journal;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBreed(): string
    {
        return $this->breed;
    }

    public function setBreed(string $breed): void
    {
        $this->breed = $breed;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function setJournal(Journal $journal): void
    {
        $this->journal = $journal;
    }

    /**
     * @return Collection<int, AnimalImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * Añadir una imagen al animal
     */
    public function addImage(AnimalImage $image): void
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAnimal($this); // Asumiendo que tienes este método
        }
    }

    /**
     * Remover una imagen del animal
     */
    public function removeImage(AnimalImage $image): void
    {
        if ($this->images->removeElement($image)) {
            $image->setAnimal(null); // Asumiendo que tienes este método
        }
    }

    /**
     * Obtener imágenes como array (si lo necesitas)
     */
    public function getImagesArray(): array
    {
        return $this->images->toArray();
    }

    public function getTimeStamp(): TimeStamp
    {
        return $this->timeStamp;
    }

    public function getSoftDelete(): SoftDelete
    {
        return $this->softDelete;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }
}
