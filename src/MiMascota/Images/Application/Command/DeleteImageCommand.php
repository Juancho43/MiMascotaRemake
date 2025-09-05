<?php

namespace App\MiMascota\Images\Application\Command;

class DeleteImageCommand
{
    public function __construct(
        public string $imageId
    )
    {

    }
}
