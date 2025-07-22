<?php

namespace App\MiMascota\Posts\Application\DTO;

use App\MiMascota\Posts\Domain\Post;

class PostResponse
{

    public static function generate(Post $post) : array
    {
        return [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'user' => $post->getUser()->getName(),
            'forum' => $post->getForum()->getName(),
            'animal' => [
                'id' => $post->getAnimal()->getId(),
                'name' => $post->getAnimal()->getName(),
            ],
            'location'=> [
                'id' => $post->getLocation()->getId(),
                'city' => $post->getLocation()->getCity(),
            ],
            'createdAt' => $post->getTimeStamp()->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $post->getTimeStamp()->getUpdatedAt() ? $post->getTimeStamp()->getUpdatedAt()->format('Y-m-d H:i:s') : null,
        ];
    }
}
