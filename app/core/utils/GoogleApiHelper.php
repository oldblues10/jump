<?php
namespace app\core\utils;

    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class GoogleApiHelper
    {
        const BASE_MAPS_API_URL = 'https://maps.googleapis.com/maps/api/';

        public static function getMapByLatitudeAndLongitude($latitude, $longitude)
        {
            return 'https://maps.googleapis.com/maps/api/staticmap?zoom=8&size=400x400&center=' . $latitude . ',' .  $longitude;
        }

        public static function getStreetViewByLatitudeAndLongitude($latitude, $longitude)
        {
            return 'https://maps.googleapis.com/maps/api/streetview?size=400x400&&location=' . $latitude . ',' .  $longitude;
        }

    }
?>