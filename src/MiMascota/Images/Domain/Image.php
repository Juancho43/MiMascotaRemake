<?php

namespace App\MiMascota\Images\Domain;

final class Image
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $path,
        private readonly string $type,
        private readonly int $size
    )
    {

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
}
