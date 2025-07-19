<?php

namespace App\MiMascota\Journals\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Journal
{

    private Collection $entries;
    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;



    private function __construct(
        private readonly string $id,
        private readonly User $user,
        private readonly Animal $animal,
    ) {
        $this->entries = new ArrayCollection();
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
    }


    public static function create(string $id, User $user,Animal $animal): self
    {
        return new self($id, $user, $animal);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAnimal(): Animal
    {
        return $this->animal;
    }
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function getEntryById($id): ?Entry
    {
        foreach ($this->entries as $entry) {
            if ($entry->getId() === $id) {
                return $entry;
            }
        }
        return null;
    }
    public function addEntry(Entry $entry): void
    {
        if (!$this->entries->contains($entry)) {
            $this->entries->add($entry);
        }
    }

    public function getUser(): User
    {
        return $this->user;
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
