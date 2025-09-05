<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\ValueObject\LocationCity;
use App\MiMascota\Locations\Domain\ValueObject\LocationCountry;
use App\MiMascota\Locations\Domain\ValueObject\LocationLatitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationLongitude;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\ValueObject\PostContent;
use App\MiMascota\Posts\Domain\ValueObject\PostReported;
use App\MiMascota\Posts\Domain\ValueObject\PostSlug;
use App\MiMascota\Posts\Domain\ValueObject\PostTitle;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;

class PostMock
{
    public static function generate($id,Forum $forum, User $user,Location $location,Animal $animal,$title='prueba',$content='contenido de prueba') :Post
    {
        return Post::create(
            $id,
            PostTitle::create($title),
            PostSlug::create(SlugGenerator::generate($title)),
            PostContent::create($content),
            PostReported::create(null),
            $forum,
            $user,
            $animal,
            $location
        );
    }
}
