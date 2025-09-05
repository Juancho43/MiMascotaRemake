<?php

namespace App\MiMascota\Images\Application\Query;

class GetImageByIdQuery
{
    public function __construct(
        public string $imageId
    )
    {

    }
}
