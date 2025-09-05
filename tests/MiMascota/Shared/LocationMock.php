<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\ValueObject\LocationCity;
use App\MiMascota\Locations\Domain\ValueObject\LocationCountry;
use App\MiMascota\Locations\Domain\ValueObject\LocationLatitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationLongitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationSlug;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;

class LocationMock
{
    public static function generate($id,$city = 'Buenos aires',$country='Argentina',$latitude='-34.6037', $longitude='-58.3816') :Location
    {
        return Location::create(
            $id,
            LocationCity::create($city),
            LocationSlug::create(SlugGenerator::generate($city)),
            LocationCountry::create($country),
            LocationLatitude::create($latitude),
            LocationLongitude::create($longitude),

        );
    }
}
