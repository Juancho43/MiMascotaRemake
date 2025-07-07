<?php
namespace App\MiMascota\Entries\Domain;

use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageableInterface;
use App\MiMascota\Journals\Domain\Journal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Entry implements ImageableInterface
{
    private Collection $images;

    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $content,
        private readonly \DateTimeImmutable $date,
        private readonly Journal $journal,
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
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
}
