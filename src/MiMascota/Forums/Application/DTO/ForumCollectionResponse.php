<?php

namespace App\MiMascota\Forums\Application\DTO;

use Doctrine\Common\Collections\Collection;


class ForumCollectionResponse
{
    public static function generate(array $forums) : array
    {
       $response = [];

        foreach ($forums as $forum) {
            $response[] = ForumResponse::generate($forum);
        }
        return $response;
    }
}
