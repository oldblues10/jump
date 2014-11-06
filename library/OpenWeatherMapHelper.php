<?php
    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class OpenWeatherMapHelper
    {
        public static function getWeatherByLatitudeAndLongitude($latitude, $longitude)
        {
            $url = "http://api.openweathermap.org/data/2.5/weather?lat=" . $latitude . "&lon=" . $longitude;
            return CurlHelper::execute($url);
        }

        public static function getConditionImageUrlByIcon($icon)
        {
            return 'http://openweathermap.org/img/w/' . $icon . '.png';
        }
    }
?>