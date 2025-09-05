<?php

namespace App\MiMascota\Images\Application;


interface StoreImage
{

    public function store(string $tmpPath, string $destPath) : bool;
}
