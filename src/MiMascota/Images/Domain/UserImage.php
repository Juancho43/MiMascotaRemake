<?php

namespace App\MiMascota\Images\Domain;

use App\MiMascota\Users\Domain\User;

class UserImage
{
    public function __construct(
        private readonly string $id,
        private User $user,
        private Image $image,
        private int $position,

    ) {

    }

}
