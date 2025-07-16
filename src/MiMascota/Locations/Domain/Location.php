<?php

namespace App\MiMascota\Locations\Domain;

use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;

class Location
{

    public function __construct
    (
        private string $id,
        private string $city,
        private string $country,
        private string $latitude,
        private string $longitude,
        private TimeStamp $timeStamp,
        private SoftDelete $softDelete
    ){

    }

    public static function create(
        string $id,
        string $city,
        string $country,
        string $latitude,
        string $longitude
    ): self {
        return new self(
            $id,
            $city,
            $country,
            $latitude,
            $longitude,
            new TimeStamp(),
            new SoftDelete()
        );
    }

}
