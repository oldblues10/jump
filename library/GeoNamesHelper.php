<?php
    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class GeoNamesHelper
    {
        public static function getFlagImageUrlByCountryCode($countryCode)
        {
            return 'http://geotree.geonames.org/img/flags18/' . $countryCode . '.png';
        }
    }
?>