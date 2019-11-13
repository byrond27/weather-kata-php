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
        $mycity = new Woeid();
        $city = $mycity->getWoeid($client,$city);
        // Find the predictions for the city
        $results = $mycity->findPrediction($client,$city);

        foreach ($results as $result) {
            // When the date is the expected
            if ($result["applicable_date"] == $datetime->format('Y-m-d')) {
                // If we have to return the wind information
                if ($wind) {
                    return $result['wind_speed'];
                } else {
                    return $result['weather_state_name'];
                }
            }
        }
    }
}

class Woeid {

    const URL = 'https://www.metaweather.com/api/location/';

    public function getWoeid ($client, $city) {
        
        $woeid = json_decode($client->get(SELF::URL.'search/?query='.$city)->getBody()->getContents(),
        true)[0]['woeid'];
        return $woeid;
    }

    public function findPrediction($client,$woeid) {
    // Find the predictions for the city
    $results = json_decode($client->get(SELF::URL.$woeid)->getBody()->getContents(),
    true)['consolidated_weather'];
    return $results;
    }

}