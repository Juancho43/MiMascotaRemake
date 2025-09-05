<?php

namespace App\MiMascota\Posts\Domain;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Posts\Domain\ValueObject\PostContent;
use App\MiMascota\Posts\Domain\ValueObject\PostReported;
use App\MiMascota\Posts\Domain\ValueObject\PostSlug;
use App\MiMascota\Posts\Domain\ValueObject\PostTitle;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\User;

class Post
{
    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;
    private function __construct(
        private string $id,
        private PostTitle $title,
        private PostSlug $slug,
        private PostContent $content,
        private PostReported $reported,
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
        PostTitle $title,
        PostSlug $slug,
        PostContent $content,
        PostReported $reported,
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
            $reported,
            $forum,
            $user,
            $animal,
            $location
        );
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
        return $this->title->getValue();
    }

    public function setTitle(PostTitle $title): void
    {
        $this->title = $title;
    }

    public function getSlug(): string
    {
        return $this->slug->getValue();
    }

    public function setSlug(PostSlug $slug): void
    {
        $this->slug = $slug;
    }

    public function getContent(): string
    {
        return $this->content->getValue();
    }

    public function setContent(PostContent $content): void
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

    public function getReported(): PostReported
    {
        return $this->reported;
    }

    public function setReported(PostReported $reported): void
    {
        $this->reported = $reported;
    }


    public function report(): void
    {
        $this->reported = PostReported::create((new \DateTime())->format('Y-m-d'));
        $this->timeStamp->update();
    }

    public function isReported(): bool
    {
        return $this->reported->getValue() !== null;
    }

    public function clearReport()
    {
        $this->reported = PostReported::create(null);
    }
}
