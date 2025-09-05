<?php

namespace App\MiMascota\Users\Application\DTO;

use App\MiMascota\Users\Domain\User;

class UserResponse
{
 public static function generate(User $user) : array
 {
     return [
         'id' => $user->getId(),
         'name' => $user->getName(),
         'email' => $user->getEmail(),
         'telephone' => $user->getTelephone(),
         'role' => $user->getRole()->getRole(),
         'location' => $user->getUserLocation()->getLocation()->getCity(),
         'createdAt' => $user->getTimeStamp()->getCreatedAt()?->format('Y-m-d H:i:s'),
         'updatedAt' => $user->getTimeStamp()->getUpdatedAt()?->format('Y-m-d H:i:s'),
     ];
 }
}
