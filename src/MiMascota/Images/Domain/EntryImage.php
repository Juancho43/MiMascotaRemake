<?php

namespace App\MiMascota\Images\Domain;


use App\MiMascota\Entries\Domain\Entry;

class EntryImage
{
    public function __construct(
        private readonly string $id,
        private Entry $entry,
        private Image $image,
        private int $position,

    ) {

    }

}
