<?php

namespace App\MiMascota\Animals\Domain;

use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use DateTime;
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
        private string $name,
        private string $description,
        private string $color,
        private string $size,
        private string $breed,
        private string $gender,
        private DateTimeImmutable $birthDate,
        private float $weight,
    ) {
        $this->posts = new ArrayCollection();
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
        DateTimeImmutable $birthDate,
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
        if ($this->images->count() >= 3) {
            throw new \Exception('Un animal no puede tener más de 3 imágenes.');
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

    public function getBirthDate(): DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function setColor(string $color): void
    {
        $this->color = $color;
    }
    public function setSize(string $size): void
    {
        $this->size = $size;
    }
    public function setBirthDate(DateTimeImmutable $birthDate): void
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
