<?php
    /**
     * Jump! Explore the world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    require_once('config.php');
    require_once('library/MiscUtil.php');
    require_once('library/CurlHelper.php');
    require_once('library/GeoNamesHelper.php');
    require_once('library/GoogleApiHelper.php');
    require_once('library/PixabayHelper.php');
    require_once('library/OpenWeatherMapHelper.php');
    require_once('library/FlightStatsHelper.php');
    //todo: gracefully handle if config.php is not present..

    $defaultConfig = array(
        'pixabay' => array(
            'username' => null,
            'key'      => null
        ),
        'flightStats' => array(
            'appId'  => null,
            'appKey' => null
        ),
    );
    $config = array_merge($defaultConfig, $config);
?>