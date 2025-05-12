<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class WeatherController extends Controller
{
    //

    public function fetchWeatherDetails(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'units' => 'required|string|in:standard,metric,imperial',
        ]);
        $apiKey=config('services.openweather.key');
        $response = Http::get("https://api.openweathermap.org/data/3.0/onecall",[
            'lat'=>$validatedData['lat'],
            'lon'=>$validatedData['lon'],
            'units'=>$validatedData['units'],
            'exclude'=>'minutely,hourly,alerts',
            'appid'=>$apiKey
        ]);
        $data = $response->json();
        return response()->json($data);
    }
}
