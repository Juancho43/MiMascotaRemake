<?php

namespace App\MiMascota\Animals\Domain;

use App\MiMascota\Animals\Domain\ValueObject\AnimalBirthDate;
use App\MiMascota\Animals\Domain\ValueObject\AnimalBreed;
use App\MiMascota\Animals\Domain\ValueObject\AnimalColor;
use App\MiMascota\Animals\Domain\ValueObject\AnimalDescription;
use App\MiMascota\Animals\Domain\ValueObject\AnimalGender;
use App\MiMascota\Animals\Domain\ValueObject\AnimalName;
use App\MiMascota\Animals\Domain\ValueObject\AnimalSize;
use App\MiMascota\Animals\Domain\ValueObject\AnimalWeight;
use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Images\Domain\HaveImages;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Animal
{
    private Journal $journal;

    /**
     * @var Collection<int, AnimalImage>
     */
    private Collection $images;
    private Collection $posts;

    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;

    private function __construct(
        private readonly string $id,
        private AnimalName $name,
        private AnimalDescription $description,
        private AnimalColor $color,
        private AnimalSize $size,
        private AnimalBreed $breed,
        private AnimalGender $gender,
        private AnimalBirthDate $birthDate,
        private AnimalWeight $weight,
    ) {
        $this->posts = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
    }

    public static function create(
        string $id,
        AnimalName $name,
        AnimalDescription $description,
        AnimalColor $color,
        AnimalSize $size,
        AnimalBreed $breed,
        AnimalGender $gender,
        AnimalBirthDate $birthDate,
        AnimalWeight $weight
    ) : self {
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
        return $this->weight->getValue();
    }

    public function getName(): string
    {
        return $this->name->getValue();
    }

    public function setName(AnimalName $name): void
    {
        $this->name = $name;
    }

    public function getBreed(): string
    {
        return $this->breed->getValue();
    }

    public function setBreed(AnimalBreed $breed): void
    {
        $this->breed = $breed;
    }

    public function getGender(): string
    {
        return $this->gender->getValue();
    }

    public function setGender(AnimalGender $gender): void
    {
        $this->gender = $gender;
    }

    public function setJournal(Journal $journal): void
    {
        $this->journal = $journal;
    }

    public function setWeight(AnimalWeight $weight): void
    {
        $this->weight = $weight;
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
        if ($this->images->count() >= 3) {
            throw new HaveImages('animal', 3);
        }
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }
    }

    /**
     * Remover una imagen del animal
     */
    public function removeImage(AnimalImage $image): void
    {
        $this->images->removeElement($image);
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
        return $this->description->getValue();
    }

    public function getColor(): string
    {
        return $this->color->getValue();
    }

    public function getSize(): string
    {
        return $this->size->getValue();
    }

    public function getBirthDate():string
    {
        return $this->birthDate->getValue()->format('Y-m-d');
    }

    public function setDescription(AnimalDescription $description): void
    {
        $this->description = $description;
    }
    public function setColor(AnimalColor $color): void
    {
        $this->color = $color;
    }
    public function setSize(AnimalSize $size): void
    {
        $this->size = $size;
    }
    public function setBirthDate(AnimalBirthDate $birthDate): void
    {
        $this->birthDate = $birthDate;
    }
    public function addPost(Post $post): void
    {
        if (!isset($this->posts)) {
            $this->posts = new ArrayCollection();
        }
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }
    }
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function removePost(Post $post): void
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
        }
    }

    public function getImage(int $index): ?AnimalImage
    {
        return $this->images->get($index) ?: null;
    }


}

