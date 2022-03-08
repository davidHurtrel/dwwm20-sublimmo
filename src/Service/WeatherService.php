<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private $httpClientInterface;
    private $lang;
    private $units;
    private $appid;

    public function __construct(HttpClientInterface $httpClientInterface)
    {
        $this->httpClientInterface = $httpClientInterface;
        $this->lang = 'fr';
        $this->units = 'metric';
        $this->appid = $_ENV['OPENWEATHER_PK'];
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
