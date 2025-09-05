<?php

namespace App\MiMascota\Forums\Application\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddForumImageCommand
{

    public function __construct(
        public string       $forumId,
        public UploadedFile $imageFile,
    )
    {

    }
}
