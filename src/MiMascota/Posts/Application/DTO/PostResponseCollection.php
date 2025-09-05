<?php

namespace App\MiMascota\Posts\Application\DTO;

class PostResponseCollection
{
    public static function generate(array $posts) : array
    {
        $response = [];
        foreach ($posts as $post) {
            $response[] = PostResponse::generate($post);
        }
        return $response;
    }
}
