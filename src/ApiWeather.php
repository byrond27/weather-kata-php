<?php

namespace Codium\CleanCode;
use GuzzleHttp\Client;

class ApiWeather implements  WeatherInterface {
  
  const URL = 'https://www.metaweather.com/api/location/';
  const WOEID_NUMBER = 0;

  public function getWoeid ($city) {
    $client = new Client();

      return json_decode($client->get(SELF::URL.'search/?query='.$city)->getBody()->getContents(),
      true)[SELF::WOEID_NUMBER]['woeid'];
  }

  public function getPrediction($woeid) {
      // Find the predictions for the city
      $client = new Client();
      return json_decode($client->get(SELF::URL.$woeid)->getBody()->getContents(),
      true)['consolidated_weather']; 
  }

}