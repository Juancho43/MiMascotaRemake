<?php

namespace App\MiMascota\Images\Domain;

use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;

class Image
{

    private SoftDelete $softDelete;
    private TimeStamp $timeStamp;
    private function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $path,
        private readonly string $type,
        private readonly int $size,
        private ?string $imageableType = null,
        private ?string $imageableId = null,
    )
    {
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
    }

    public static function create(
        string $id,
        string $name,
        string $path,
        string $type,
        int $size,
        ?string $imageableType = null,
        ?string $imageableId = null
    ): self
    {
        return new self($id, $name, $path, $type, $size, $imageableType, $imageableId);
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

    public function getImageableId(): ?string
    {
        return $this->imageableId;
    }

    public function setImageableId(?string $imageableId): void
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

    public function getSoftDelete(): SoftDelete
    {
        return $this->softDelete;
    }

    public function getTimeStamp(): TimeStamp
    {
        return $this->timeStamp;
    }


}
