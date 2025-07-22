<?php

namespace App\MiMascota\Forums\Application\DTO;

use App\MiMascota\Forums\Domain\Forum;

class ForumResponse
{
    public static function generate(Forum $forum): array
    {
        return [
            'id' => $forum->getId(),
            'name' => $forum->getName(),
            'slug' => $forum->getSlug(),
            'description' => $forum->getDescription(),
            'createdAt' => $forum->getTimeStamp()->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $forum->getTimeStamp()->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
