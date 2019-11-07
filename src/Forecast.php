<?php

namespace Codium\CleanCode;

use GuzzleHttp\Client;

const NUMBER = 0;
const API_URL = 'https://www.metaweather.com/api/location/';

class Forecast
{
    public function predict(string &$city, \DateTime $datetime = null, bool $wind = false): string
    {
        // When date is not provided we look for the current prediction
        if (!$datetime) {
            $datetime = new \DateTime();
        }

        // If there are predictions
        if ($datetime >= new \DateTime("+6 days 00:00:00")) {
            return "";
        }

        // Create a Guzzle Http Client
        $client = new Client();
        $newCity = new City($client,$city);

        // Find the id of the city on metawheather
        $city = $newCity->getWoeid();;

        // Find the predictions for the city
        $results = $newCity->getPredictionResults();
        foreach ($results as $result) {
            // When the date is the expected
            if ($result["applicable_date"] == $datetime->format('Y-m-d')) {
                // If we have to return the wind information
                return ($wind) ? $result['wind_speed']: $result['weather_state_name'];
            }
        }
    }
}

class City{
    private $woeid;
    private $results;
    public $name;

    function __construct($client,$city) {
        $this->name = $city;
        $this->setWoeid($client,$city);
        $this->setPredictionResults($client,$this->getWoeid());
    }

    function setWoeid($client,$city){
        $this->woeid = json_decode($client->get(API_URL.'search/?query='.$city)->getBody()->getContents(),
        true)[NUMBER]['woeid'];
    }

    function getWoeid(){
        return $this->woeid;
    }

    function setPredictionResults($client,$woeid){
        $this->results = json_decode($client->get(API_URL.$woeid)->getBody()->getContents(),
            true)['consolidated_weather'];
    }

    function getPredictionResults(){
        return $this->results;
    }

}