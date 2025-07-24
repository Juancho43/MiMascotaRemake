<?php
namespace App\MiMascota\Entries\Domain;

use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Images\Domain\EntryImage;
use App\MiMascota\Images\Domain\HaveImages;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Entry
{
    private Collection $images;
    private SoftDelete $softDelete;
    private TimeStamp $timeStamp;

    public function __construct(
        private readonly string $id,
        private string $title,
        private string $content,
        private \DateTime $date,
        private Journal $journal,
    ) {
        $this->images = new ArrayCollection();
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
    }


    public static function create($id, string $title, string $content, \DateTime $date, Journal $journal): self
    {
        return new self($id, $title, $content, $date, $journal);
    }

    public function getJournal(): Journal
    {
        return $this->journal;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
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

    public function getDate(): \DateTime
    {
        return $this->date;
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
    public function addImage(EntryImage $image): void
    {
        if ($this->images->count() >= 3) {
            throw new HaveImages('Entry',3);
        }
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }
    }

    /**
     * Remover una imagen del animal
     */
    public function removeImage(EntryImage $image): void
    {
        $this->images->removeElement($image);
    }

    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }

    public function setSoftDelete(SoftDelete $softDelete): void
    {
        $this->softDelete = $softDelete;
    }

    public function setTimeStamp(TimeStamp $timeStamp): void
    {
        $this->timeStamp = $timeStamp;
    }

    public function setJournal(Journal $journal): void
    {
        $this->journal = $journal;
    }

    public function getTimeStamp(): TimeStamp
    {
        return $this->timeStamp;
    }

    public function getSoftDelete(): SoftDelete
    {
        return $this->softDelete;
    }




}
