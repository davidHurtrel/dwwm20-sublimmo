<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private $httpClientInterface;
    private $lang = 'fr';
    private $units = 'metric';
    private $appid = '';

    public function __construct(HttpClientInterface $httpClientInterface)
    {
        $this->httpClientInterface = $httpClientInterface;
    }

    /**
     * Renvoie la météo
     */
    public function getWeatherData($city)
    {
        $response = $this->httpClientInterface->request(
            'GET',
            "http://api.openweathermap.org/data/2.5/weather?q={$city}&units={$this->units}&lang={$this->lang}&appid={$this->appid}"
        );
        return $response->toArray();
    }
}
