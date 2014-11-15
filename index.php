<?php
    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    require_once('bootstrap.php');

    if(isset($_GET['currentAirportCode']))
    {
        $currentAirportCode = $_GET['currentAirportCode'];
        $atHome             = false;
    }
    else
    {
        $currentAirportCode = 'ORD';
        $atHome             = true;
    }
    if(isset($_GET['jump']))
    {
        $jumped = (bool)$_GET['jump'];
    }
    else
    {
        $jumped = false;
    }

    $flightStatsHelper         = new FlightStatsHelper($config['flightStats']['appId'], $config['flightStats']['appKey']);
    $currentAirportData        = $flightStatsHelper->getAirportDataByCode($currentAirportCode);
    $currentAirportWeatherData = OpenWeatherMapHelper::getWeatherByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);
    $weatherConditionIconUrl   = OpenWeatherMapHelper::getConditionImageUrlByIcon($currentAirportWeatherData['weather'][0]['icon']);
    $mapUrl                    = GoogleApiHelper::getMapByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);
    $streetViewUrl             = GoogleApiHelper::getStreetViewByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);


    if(isset($_GET['localArrivalTimeStamp']))
    {
        $localTimeStamp = $_GET['localArrivalTimeStamp'];
    }
    else
    {
        $localTimeStamp = strtotime($currentAirportData['localTime']);
    }



//todo: resolve and filter scheduledFlights by codeShare = false


//$searchTerm    =  urlencode($currentAirportData['city'] . ' ' .  $currentAirportData['countryName']);
    //$pixabayHelper = new PixabayHelper($config['pixabay']['username'], $config['pixabay']['key']);
    //$pixabayImageUrl =$pixabayHelper->getImageUrl($searchTerm);
    // echo "<img src='" . $pixabayImageUrl . "'>";






    echo "<html>";
    echo "<img src='" . $mapUrl . "'>";
    echo "<img src='" . $streetViewUrl . "'>";
    echo "<BR>weather:<BR>" . $currentAirportWeatherData['weather'][0]['description'] .
         "<BR><img src='" . $weatherConditionIconUrl  . "'><BR>";
    echo "current temp: " . MiscUtil::convertKelvinToFarenheit($currentAirportWeatherData['main']['temp']) . "<BR>";
    echo "max temp: " . MiscUtil::convertKelvinToFarenheit($currentAirportWeatherData['main']['temp_min']) . "<BR>";
    echo "min temp: " . MiscUtil::convertKelvinToFarenheit($currentAirportWeatherData['main']['temp_max']) . "<BR>";


//todo: fids data should help overlay scheduled data, that is all really.. with terminal/gate and remarks
/**
        if($jumped || $atHome)
        {
            $airportFidsData = $flightStatsHelper->getFidsByAirportCode($currentAirportCode);
            // echo "<pre>";
            // print_r($airportFidsData);
            // echo "</pre>";
            ViewUtil::renderFidsView($currentAirportData, $localTimeStamp, $airportFidsData);
        }
        else
        {
**/
            echo date("F j, Y, g:i a", $localTimeStamp);
            $airportScheduledData = $flightStatsHelper->getScheduledFlightsByAirportCodeAndDateAndTime(
                $currentAirportCode,
                date('Y', $localTimeStamp),
                date('n', $localTimeStamp),
                date('j', $localTimeStamp),
                date('G', $localTimeStamp));
       //   echo "<pre>";
         // print_r($airportScheduledData);
        //  echo "</pre>";
        //   exit;
            //todo; i think time would be wrong. watch out on fly to
            ViewUtil::renderScheduledView($currentAirportData, $localTimeStamp, $airportScheduledData);
      //  }

    echo "</body></html>"
?>