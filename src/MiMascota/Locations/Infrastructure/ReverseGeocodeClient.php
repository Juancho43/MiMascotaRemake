<?php

namespace App\MiMascota\Locations\Infrastructure;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClientTrait;

class ReverseGeocodeClient
{
    use HttpClientTrait;
    private string $apiBaseUrl;
    private HttpClientInterface $httpClient;

    public function __construct(
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
}
