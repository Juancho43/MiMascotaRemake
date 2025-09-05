<?php

namespace App\MiMascota\Locations\Domain;

use App\MiMascota\Locations\Domain\ValueObject\LocationCity;
use App\MiMascota\Locations\Domain\ValueObject\LocationCountry;
use App\MiMascota\Locations\Domain\ValueObject\LocationLatitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationLongitude;
use App\MiMascota\Locations\Domain\ValueObject\LocationSlug;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;

class Location
{

    private function __construct
    (
        private readonly string $id,
        private LocationCity $city,
        private LocationSlug $slug,
        private LocationCountry $country,
        private LocationLatitude $latitude,
        private LocationLongitude $longitude,
        private TimeStamp $timeStamp,
        private SoftDelete $softDelete
    ){

    }



    public static function create(
        string $id,
        LocationCity $city,
        LocationSlug $slug,
        LocationCountry $country,
        LocationLatitude $latitude,
        LocationLongitude $longitude
    ): self {
        return new self(
            $id,
            $city,
            $slug,
            $country,
            $latitude,
            $longitude,
            new TimeStamp(),
            new SoftDelete()
        );
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getCity(): string
    {
        return $this->city->getValue();
    }



    public function getCountry(): string
    {
        return $this->country->getValue();
    }



    public function getLatitude(): string
    {
        return $this->latitude->getValue();
    }

       public function getLongitude(): string
    {
        return $this->longitude->getValue();
    }

    public function setCity(LocationCity $city): void
    {
        $this->city = $city;
    }

    public function setCountry(LocationCountry $country): void
    {
        $this->country = $country;
    }

    public function setLatitude(LocationLatitude $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function setLongitude(LocationLongitude $longitude): void
    {
        $this->longitude = $longitude;
    }

       public function getTimeStamp(): TimeStamp
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(TimeStamp $timeStamp): void
    {
        $this->timeStamp = $timeStamp;
    }

    public function getSoftDelete(): SoftDelete
    {
        return $this->softDelete;
    }

    public function setSoftDelete(SoftDelete $softDelete): void
    {
        $this->softDelete = $softDelete;
    }

    public function getSlug(): LocationSlug
    {
        return $this->slug;
    }

    public function setSlug(LocationSlug $slug): void
    {
        $this->slug = $slug;
    }



}
