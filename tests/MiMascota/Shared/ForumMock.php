<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ValueObject\ForumDescription;
use App\MiMascota\Forums\Domain\ValueObject\ForumName;
use App\MiMascota\Forums\Domain\ValueObject\ForumSlug;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\ValueObject\LocationCity;
use App\MiMascota\Locations\Domain\ValueObject\LocationCountry;
use App\MiMascota\Locations\Domain\ValueObject\LocationLatitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationLongitude;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\ValueObject\PostContent;
use App\MiMascota\Posts\Domain\ValueObject\PostSlug;
use App\MiMascota\Posts\Domain\ValueObject\PostTitle;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;

class ForumMock
{
    public static function generate($id,$title='prueba',$content='contenido mockeado') :Forum
    {
        return Forum::create(
            $id,
            ForumName::create($title),
            ForumSlug::create(SlugGenerator::generate($title)),
            ForumDescription::create($content),

        );
    }
}
