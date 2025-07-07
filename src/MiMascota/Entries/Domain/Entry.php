<?php
namespace App\MiMascota\Entries\Domain;

use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Journals\Domain\Journal;

final class Entry
{

    /** @var array<Image> */
    private array $images = [];
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly string $content,
        private readonly \DateTimeImmutable $date,
        private readonly Journal $journal,
    ) {
    }

    public function getJournal(): Journal
    {
        return $this->journal;
    }

    public function getImages(): array
    {
        return $this->images;
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
}
