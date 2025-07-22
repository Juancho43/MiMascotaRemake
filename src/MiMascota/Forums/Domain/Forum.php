<?php

namespace App\MiMascota\Forums\Domain;

use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Forum
{
    private Collection $posts;
    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;
    private function __construct(
        private string $id,
        private string $name,
        private string $slug,
        private string $description,

    )
    {
        $this->setId($id);
        $this->setName($name);
        $this->setSlug($slug);
        $this->setDescription($description);
        $this->posts = new ArrayCollection();
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
    }
    public static function create(string $id, string $name, string $slug, string $description): self
    {
        return new self($id, $name, $slug, $description);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Forum ID cannot be empty.');
        }
        $this->id = $id;
    }

    public function getName(): string
    {

        return $this->name;
    }

    public function setName(string $name): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Forum name cannot be empty.');
        }
        $this->name = $name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        if (empty($slug)) {
            throw new \InvalidArgumentException('Forum slug cannot be empty.');
        }
        $this->slug = $slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        if (empty($description)) {
            throw new \InvalidArgumentException('Forum description cannot be empty.');
        }
        $this->description = $description;
    }

    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function getTimeStamp(): TimeStamp
    {
        return $this->timeStamp;
    }

    public function getSoftDelete(): SoftDelete
    {
        return $this->softDelete;
    }

    public function addPost(Post $post): void
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }
    }

    public function delete(): void
    {
        $this->softDelete->markAsDeleted();
    }

    public function deletePost(Post $post): void
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
        }
    }



}
