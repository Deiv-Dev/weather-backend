<?php
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use TheSeer\Tokenizer\Exception;
use Validator;
use App\Service\WeatherFilter;
use App\Service\WeatherApi;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    const CACHE_TIME = 300; // 5min
    const CACHE_CITIES = "citie-names"; // 5min

    public function getCityNames()
    {
        if (Cache::has(self::CACHE_CITIES)) {
            return (array) Cache::get(self::CACHE_CITIES);
        }
        try {
            $url = "https://api.meteo.lt/v1/places";
            $response = Http::get($url);
            $places = $response->json();
            $cityNames = array();
            foreach ($places as $place) {
                if (!in_array($place['name'], $cityNames)) {
                    $cityNames[] = $place['name'];
                }
            }
            Cache::put(self::CACHE_CITIES, $cityNames, self::CACHE_TIME);
            return $cityNames;
        } catch (Exception $e) {
            return response()->json(["error" => "request failed"], 500);
        }
    }

    public function processForm(Request $request): JsonResponse
    {
        $validatet = Validator::make($request->all(), ['city' => 'required|string|max:25']);

        if ($validatet->fails()) {
            return response()
                ->json(["error" => "Text input is not correct"], 400);
        }

        $city = strtolower($request->input('city'));
        try {
            $weatherData = WeatherApi::getCityWeather($city);

            // Fill ter weather to 3 next days with 2 clothes recomendations for each day
            $recommendation = WeatherFilter::filter($weatherData);
            if (count($recommendation) === 0) {
                return response()->json(["message" => "no recommendatios found"], 200);
            }

            return response()->json($recommendation, 200);
        } catch (\Exception $e) {
            return response()->json(["error" => "request failed"], 500);
        }
    }
}