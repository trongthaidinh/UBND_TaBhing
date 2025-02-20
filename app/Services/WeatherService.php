<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    private $city;
    private $coordinates;
    private $cacheTime;

    // Predefined provinces with their coordinates
    private $provinces = [
        'Nam Giang' => [
            'latitude' => 15.4167,
            'longitude' => 107.7167,
            'full_name' => 'Nam Giang, Quảng Nam'
        ],
        'Đắc Tôi' => [
            'latitude' => 15.4167,
            'longitude' => 107.7167,
            'full_name' => 'Đắc Tôi, Nam Giang, Quảng Nam'
        ],
        // Add more provinces here
    ];

    public function __construct($province = 'Nam Giang')
    {
        $this->setProvince($province);
        $this->cacheTime = 30; // Cache for 30 minutes
    }

    public function setProvince($province)
    {
        // Validate and set province
        $province = ucwords(strtolower($province));
        if (!isset($this->provinces[$province])) {
            $province = 'Nam Giang'; // Default if not found
        }

        $selectedProvince = $this->provinces[$province];
        $this->coordinates = [
            'latitude' => $selectedProvince['latitude'],
            'longitude' => $selectedProvince['longitude']
        ];
        $this->city = $selectedProvince['full_name'];
    }

    public function getAvailableProvinces()
    {
        return array_keys($this->provinces);
    }

    public function getCurrentCity()
    {
        return $this->city;
    }

    public function getCurrentWeather()
    {
        return Cache::remember('quang_nam_weather', now()->addMinutes($this->cacheTime), function () {
            try {
                $response = Http::withOptions([
                    'verify' => false  // Disable SSL verification
                ])->get("https://api.open-meteo.com/v1/forecast", [
                    'latitude' => $this->coordinates['latitude'],
                    'longitude' => $this->coordinates['longitude'],
                    'current_weather' => true,
                    'timezone' => 'Asia/Ho_Chi_Minh'
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $currentWeather = $data['current_weather'];

                    // Map weather codes to descriptions
                    $weatherCodes = [
                        0 => 'Quang đãng',
                        1 => 'Chủ yếu quang đãng',
                        2 => 'Có mây rải rác',
                        3 => 'Nhiều mây',
                        45 => 'Sương mù',
                        48 => 'Sương mù kết đọng',
                        51 => 'Mưa phùn nhẹ',
                        53 => 'Mưa phùn vừa',
                        55 => 'Mưa phùn nặng',
                        61 => 'Mưa nhẹ',
                        63 => 'Mưa vừa',
                        65 => 'Mưa lớn'
                    ];

                    return [
                        'temperature' => round($currentWeather['temperature']),
                        'description' => $weatherCodes[$currentWeather['weathercode']] ?? 'Thời tiết',
                        'windspeed' => $currentWeather['windspeed']
                    ];
                }
            } catch (\Exception $e) {
                // Log the error if needed
                \Log::error('Weather API Error: ' . $e->getMessage());
            }

            return null;
        });
    }
}