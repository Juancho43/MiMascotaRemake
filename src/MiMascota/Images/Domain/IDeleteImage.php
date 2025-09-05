<?php

namespace App\MiMascota\Images\Domain;

interface IDeleteImage
{
    public function delete(string $path): void;

}
