<?php
namespace App\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherApi
{
    const CACHE_TIME = 300; // 5min

    public static function getCityWeather(string $city): array
    {
        if (Cache::has($city)) {
            return (array) Cache::get($city);
        }

        $url = "https://api.meteo.lt/v1/places/$city/forecasts/long-term";
        $response = Http::get($url);
        $weatherData = $response->json();

        Cache::put($city, $weatherData, self::CACHE_TIME);

        return $weatherData;
    }
}