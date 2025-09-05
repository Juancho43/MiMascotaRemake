<?php

namespace App\MiMascota\Forums\Domain;

use App\MiMascota\Forums\Domain\ValueObject\ForumDescription;
use App\MiMascota\Forums\Domain\ValueObject\ForumImage;
use App\MiMascota\Forums\Domain\ValueObject\ForumName;
use App\MiMascota\Forums\Domain\ValueObject\ForumSlug;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Forum
{
    private Collection $posts;
    private ForumImage | null $image;
    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;
    private function __construct(
        private string $id,
        private ForumName $name,
        private ForumSlug $slug,
        private ForumDescription $description,


    )
    {
        $this->posts = new ArrayCollection();
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
    }
    public static function create(string $id, ForumName $name, ForumSlug $slug, ForumDescription $description): self
    {
        return new self($id, $name, $slug, $description);
    }

    public function addImage(ForumImage $image): void
    {
        $this->image = $image;
    }
    public function deleteImage() : void
    {
        $this->image = null;
    }
    public function getImage() : ?ForumImage
    {
        return $this->image;
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
        return $this->name->getValue();
     }

    public function setName(ForumName $name): void
    {
        $this->name = $name;
    }

    public function getSlug(): string
    {
        return $this->slug->getValue();
    }

    public function setSlug(ForumSlug $slug): void
    {

        $this->slug = $slug;
    }

    public function getDescription(): string
    {
        return $this->description->getValue();
    }

    public function setDescription(ForumDescription $description): void
    {
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

    public function getPostsCount(): int
    {
        return $this->posts->count();
    }


}
