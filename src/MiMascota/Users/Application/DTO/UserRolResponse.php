<?php

namespace App\MiMascota\Users\Application\DTO;

use App\MiMascota\Users\Domain\User;

class UserRolResponse
{
 public static function generate(User $user) : array
 {
     return [
         'role' => $user->getRole()->getRole(),
     ];
 }
}
