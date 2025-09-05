<?php

namespace App\MiMascota\Entries\Application\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateEntryImageCommand
{
    public function __construct(
        public string $entryId,
        public UploadedFile $file,
        public int $position
    )
    {

    }
}
