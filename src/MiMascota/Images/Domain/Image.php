<?php

namespace App\MiMascota\Images\Domain;

final class Image
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $path,
        private readonly string $type,
        private readonly int $size,
        private readonly string $mimeType,
        private ?string $imageableType = null,
        private ?int $imageableId = null,
        private ?ImageableInterface $imageable = null,
)
    {

    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getImageable(): ?ImageableInterface
    {
        return $this->imageable;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSize(): int
    {
        return $this->size;
    }
    public function setImageable(?ImageableInterface $imageable): self
    {
        $this->imageable = $imageable;

        if ($imageable) {
            $this->imageableType = get_class($imageable);
            $this->imageableId = $imageable->getId();
        } else {
            $this->imageableType = null;
            $this->imageableId = null;
        }

        return $this;
    }

    public function getImageableId(): ?int
    {
        return $this->imageableId;
    }

    public function setImageableId(?int $imageableId): void
    {
        $this->imageableId = $imageableId;
    }

    public function getImageableType(): ?string
    {
        return $this->imageableType;
    }

    public function setImageableType(?string $imageableType): void
    {
        $this->imageableType = $imageableType;
    }


}
