<?php

namespace App\MiMascota\Posts\Application\DTO;

use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Animals\Application\DTO\AnimalShortResponse;
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
            'user' =>[
               'id' => $post->getUser()->getId(),
            ],

            'forum' => $post->getForum()->getName(),
            'animal' => AnimalShortResponse::generate($post->getAnimal()),
            'location'=> [
                'id' => $post->getLocation()->getId(),
                'city' => $post->getLocation()->getCity(),
            ],
            'createdAt' => $post->getTimeStamp()->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $post->getTimeStamp()->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
