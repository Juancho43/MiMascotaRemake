<?php

namespace App\MiMascota\Images\Domain;

use App\MiMascota\Images\Domain\Image;

interface ImageRepository
{
    public function search(string $id): ?Image;

    public function save(Image $image): void;

    public function remove(Image $image): void;
}
