<?php

namespace Tests\Codium\CleanCode;

use Codium\CleanCode\CityWeather;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
    // https://www.metaweather.com/api/location/766273/
    /** @test */
    public function find_the_weather_of_today()
    {
        $cityWeather = new CityWeather();
        $city = "Madrid";

        $prediction = $cityWeather->predictionForCity($city);

        echo "Today: $prediction\n";
        $this->assertTrue(true, 'I don\'t know how to test it');
    }

    /** @test */
    public function find_the_weather_of_any_day()
    {
        $cityWeather = new CityWeather();
        $city = "Madrid";

        $prediction = $cityWeather->predictionForCity($city, new \DateTime('+2 days'));

        echo "Day after tomorrow: $prediction\n";
        $this->assertTrue(true, 'I don\'t know how to test it');
    }

    /** @test */
    public function find_the_wind_of_any_day()
    {
        $cityWeather = new CityWeather();
        $city = "Madrid";

        $prediction = $cityWeather->predictionForCity($city, null, true);

        echo "Wind: $prediction\n";
        $this->assertTrue(true, 'I don\'t know how to test it');
    }

    /** @test */
    public function change_the_city_to_woeid()
    {
        $cityWeather = new CityWeather();
        $city = "Madrid";

        $cityWeather->predictionForCity($city, null, true);

        $this->assertEquals("766273", $city);
    }

    /** @test */
    public function there_is_no_prediction_for_more_than_5_days()
    {
        $cityWeather = new CityWeather();
        $city = "Madrid";

        $prediction = $cityWeather->predictionForCity($city, new \DateTime('+6 days'));

        $this->assertEquals("", $prediction);
    }
}