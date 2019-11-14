<?php

namespace Codium\CleanCode;

class CityWeather
{
    CONST DATE_PREDICTION = "+6 days 00:00:00";
    CONST EMPTY_STRING = "";
    CONST FORMAT_DATETIME = "Y-m-d";
    
    public function predict(string &$city, \DateTime $datetime = null, bool $wind = false): string
    {
        // When date is not provided we look for the current prediction
        if (!$datetime) {
            $datetime = new \DateTime();
        }

        // If there are predictions
        if ($datetime >= new \DateTime(self::DATE_PREDICTION)) {
            return self::EMPTY_STRING;
        }
        // Create a Guzzle Http Client

        // Find the id of the city on metawheather
        $newApiWeather = new ApiWeather();
        $mycity = new City($city,$newApiWeather);
        $city = $mycity->id;
        // Find the predictions for the city
        $results = $mycity->prediction;

        foreach ($results as $result) {
            // When the date is the expected
            if ($result["applicable_date"] == $datetime->format(self::FORMAT_DATETIME) && $wind) {
            // If we have to return the wind information
                return $result['wind_speed'];
            }
            return $result['weather_state_name'];
        }
    }
}