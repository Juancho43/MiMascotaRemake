<?php

namespace App\MiMascota\Posts\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\User;

class Post
{
    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;
    private function __construct(
        private string $id,
        private string $title,
        private string $slug,
        private string $content,
        private Forum $forum,
        private User $user,
        private Animal $animal,
        private Location $location,

    )
    {
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
    }

    public static function create(
        string $id,
        string $title,
        string $slug,
        string $content,
        Forum $forum,
        User $user,
        Animal $animal,
        Location $location
    ): self {
        return new self(
            $id,
            $title,
            $slug,
            $content,
            $forum,
            $user,
            $animal,
            $location
        );
    }
    public function edit(string $title, string $content): void
    {
        $this->title = $title;
        $this->content = $content;
        $this->timeStamp->update();
    }

    public function delete(): void
    {
        $this->softDelete->markAsDeleted();
        $this->timeStamp->update();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getForum(): Forum
    {
        return $this->forum;
    }

    public function setForum(Forum $forum): void
    {
        $this->forum = $forum;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getAnimal(): Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): void
    {
        $this->animal = $animal;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function getSoftDelete(): SoftDelete
    {
        return $this->softDelete;
    }

    public function getTimeStamp(): TimeStamp
    {
        return $this->timeStamp;
    }


}
