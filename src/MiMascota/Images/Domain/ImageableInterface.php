<?php
namespace App\MiMascota\Images\Domain;

use Doctrine\Common\Collections\Collection;

interface ImageableInterface
{
    public function getId(): ?string;

    public function getImages(): Collection;
    public function getImage(string $id): ?Image;

    public function addImage(Image $image): self;

    public function removeImage(Image $image): self;
}
