<?php

namespace App\MiMascota\Forums\Domain\ValueObject;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class ForumImage
{
    public function __construct(
        private readonly string $id,
        private Forum $forum,
        private Image $image,
    ){

    }
    public static function create(
        string $id,
        Forum $forum,
        Image $image,
    ): self {
        return new self($id, $forum, $image);
    }

    public function getImage(): Image
    {
        return $this->image;
    }
    public function getForum(): Forum
    {
        return $this->forum;
    }
    public function getId(): string
    {
        return $this->id;
    }
}
