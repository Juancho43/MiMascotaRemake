<?php

namespace App\MiMascota\Images\Domain;

use App\MiMascota\Users\Domain\User;

class UserImage
{
    private function __construct(
        private readonly string $id,
        private User $user,
        private Image $image,

    ) {

    }

    public static function create(string $id, User $user, Image $image ) : self
    {
        return new self($id,$user,$image);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getImage(): Image
    {
        return $this->image;
    }


}
