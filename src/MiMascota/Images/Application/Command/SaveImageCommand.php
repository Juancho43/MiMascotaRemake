<?php

namespace App\MiMascota\Images\Application\Command;

class SaveImageCommand
{
    public function __construct(
        public string $temporalPath,
        public string $mimeType,
        public string $size,
        public string $imageableType,
        public string $imageableId,
    )
    {
    }
}
