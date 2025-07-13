<?php
namespace App\MiMascota\Entries\Domain;

use App\MiMascota\Images\Domain\EntryImage;
use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageableInterface;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Entry
{
    private EntryImage $images;
    private SoftDelete $softDelete;
    private TimeStamp $timeStamp;

    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $content,
        private readonly \DateTime $date,
        private Journal $journal,
    ) {

    }


    public static function create($id, string $title, string $content, \DateTime $date, Journal $journal): self
    {
        return new self($id, $title, $content, $date, $journal);
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

    public function getDate(): \DateTime
    {
        return $this->date;
    }



}
