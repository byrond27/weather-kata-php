<?php

namespace Codium\CleanCode;

class City {
  
  const URL = 'https://www.metaweather.com/api/location/';
  const ARRAY_NUMBER = 0;

  public function getWoeid ($client, $city) {
      return json_decode($client->get(SELF::URL.'search/?query='.$city)->getBody()->getContents(),
      true)[SELF::ARRAY_NUMBER]['woeid'];
  }

  public function findPrediction($client,$woeid) {
      // Find the predictions for the city
      return json_decode($client->get(SELF::URL.$woeid)->getBody()->getContents(),
      true)['consolidated_weather']; 
  }

}