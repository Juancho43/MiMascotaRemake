<?php

namespace App\MiMascota\Animals\Domain;

use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageableInterface;
use App\MiMascota\Journals\Domain\Journal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Animal implements ImageableInterface
{
    private Journal $journal;
    private Collection $images;

    private function __construct(
        private readonly string $id,
        private string $name,
        private string $breed,
        private int $age,
        private string $gender,
        private float $weight,
    ) {
        $this->images = new ArrayCollection();
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

    public static function create(string $id, string $name, string $breed, int $age, string $gender, string $weight): self
    {
        return new self($id, $name, $breed, $age, $gender, $weight);
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

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s, %s, %s, %d years old',
            $this->name,
            $this->breed,
            $this->gender,
            $this->age
        );
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setImageable($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getImageable() === $this) {
                $image->setImageable(null);
            }
        }

        return $this;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

   public function getImage(string $id): ?Image
   {
       foreach ($this->images as $image) {
           if ($image->getId() === $id) {
               return $image;
           }
       }

       return null;
   }

    public function setJournal(Journal $journal)
    {
        $this->journal = $journal;
    }
}
