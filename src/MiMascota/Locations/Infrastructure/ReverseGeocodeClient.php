<?php

namespace App\MiMascota\Locations\Infrastructure;

use App\MiMascota\Locations\Application\LocationCreator;
use App\MiMascota\Locations\Application\SaveLocation;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationResolver;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClientTrait;

class ReverseGeocodeClient implements LocationResolver
{
    use HttpClientTrait;
    private string $apiBaseUrl;
    private HttpClientInterface $httpClient;

    public function __construct(
        private SaveLocation $saveLocation,
        HttpClientInterface $httpClient,
        string $apiBaseUrl = 'https://api.bigdatacloud.net/data/reverse-geocode-client'
    ) {
        $this->httpClient = $httpClient;
        $this->apiBaseUrl = $apiBaseUrl;
    }

    public function reverseGeocode(float $latitude, float $longitude): array
    {

        $url = sprintf(
            '%s?latitude=%s&longitude=%s&localityLanguage=es',
            $this->apiBaseUrl,
            $latitude,
            $longitude
        );

        $response = $this->httpClient->request('GET', $url);

        return $response->toArray();
    }

    public function getLocation(float $latitude, float $longitude): Location
    {
        $response = $this->reverseGeocode($latitude, $longitude);
       return $this->saveLocation->__invoke(
            $response['locality'] ?? '',
            $response['countryName'] ?? '',
            $latitude,
            $longitude
        );
    }
}
