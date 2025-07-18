<?php

namespace App\MiMascota\Locations\Domain;

use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;

class Location
{

    public function __construct
    (
        private readonly string $id,
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
    public function getId(): string
    {
        return $this->id;
    }
    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): void
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


}
