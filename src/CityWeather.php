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
        // Find the id of the city on metawheather
        $newApiWeather = new ApiWeather();
        $mycity = new City($city,$newApiWeather);
        $city = $mycity->getId();
        // Find the predictions for the city
        return $this->getActualPrediction($mycity->getPredictions(),$datetime,$wind);
    }

    public function getActualPrediction($prections,$datetime,$wind){
        foreach ($prections as $prediction) {
            // When the date is the expected
            if ($prediction["applicable_date"] == $datetime->format(self::FORMAT_DATETIME) && $wind) {
            // If we have to return the wind information
                return $prediction['wind_speed'];
            }
            return $prediction['weather_state_name'];
        }
    }
}