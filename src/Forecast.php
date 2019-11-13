<?php

namespace Codium\CleanCode;

use GuzzleHttp\Client;

class Forecast
{
    CONST DATE_PREDICTION = "+6 days 00:00:00";
    
    public function predict(string &$city, \DateTime $datetime = null, bool $wind = false): string
    {
        // When date is not provided we look for the current prediction
        if (!$datetime) {
            $datetime = new \DateTime();
        }

        // If there are predictions
        if ($datetime >= new \DateTime(self::DATE_PREDICTION)) {
            return "";
        }
        // Create a Guzzle Http Client
        $client = new Client();

        // Find the id of the city on metawheather
        $mycity = new City();
        $city = $mycity->getWoeid($client,$city);
        // Find the predictions for the city
        $results = $mycity->findPrediction($client,$city);

        foreach ($results as $result) {
            // When the date is the expected
            if ($result["applicable_date"] == $datetime->format('Y-m-d') && $wind) {
            // If we have to return the wind information
                return $result['wind_speed'];
            }
            return $result['weather_state_name'];
        }
    }
}