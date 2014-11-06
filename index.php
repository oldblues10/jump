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
    }
    else
    {
        $currentAirportCode = 'ORD';
    }
    $flightStatsHelper         = new FlightStatsHelper($config['flightStats']['appId'], $config['flightStats']['appKey']);
    $currentAirportData        = $flightStatsHelper->getAirportDataByCode($currentAirportCode);
    $currentAirportWeatherData = OpenWeatherMapHelper::getWeatherByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);
    $airportFidsData           = $flightStatsHelper->getFidsByAirportCode($currentAirportCode);
    $weatherConditionIconUrl   = OpenWeatherMapHelper::getConditionImageUrlByIcon($currentAirportWeatherData['weather'][0]['icon']);
    $mapUrl                    = GoogleApiHelper::getMapByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);
    $streetViewUrl             = GoogleApiHelper::getStreetViewByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);


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

    if(isset($airportFidsData['fidsData']))
    {
        echo "<h1>" . $currentAirportData['city'] . ' - ' . $currentAirportData['countryName'] . " - " . $currentAirportData['fs'] . "</h1>";
        echo "<table border=1>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td>Airline Name</td>";
        echo "<td>Airline Code</td>";
        echo "<td>Flight Number</td>";
        echo "<td>Remarks</td>";
        echo "<td>City/Airport</td>";
        echo "<td>Country Code</td>";
        echo "<td>Terminal/Gate</td>";
        echo "<td>CurrentTime</td>";
        echo "</tr>";
        foreach ($airportFidsData['fidsData'] as $flightData)
        {
            if($flightData['destinationCountryCode'] == 'US' && $flightData['originCountryCode'] == 'US')
            {
                continue;
            }
            $flagImageUrl = GeoNamesHelper::getFlagImageUrlByCountryCode($flightData['destinationCountryCode']);
            echo "<tr>";
            echo "<td><img src='" . $flightData['airlineLogoUrlPng'] . "' height=50 width=150></td>";
            echo "<td>" . $flightData['airlineName'] . "</td>";
            echo "<td>" . $flightData['airlineCode'] . "</td>";
            echo "<td>" . $flightData['flightNumber'] . "</td>";
            echo "<td>" . $flightData['remarks'] . "</td>";
            echo "<td>" . $flightData['city'] . " - <a href='?currentAirportCode=" . $flightData['destinationAirportCode'] . "'>" .
                          $flightData['destinationAirportCode']. "</a></td>";
            echo "<td>" . $flightData['destinationCountryCode'] .
                          " <img src='" . $flagImageUrl.  "'/></td>";
            if(isset($flightData['terminal']) && isset($flightData['gate']))
            {
                echo "<td>T-" . $flightData['terminal'] . "<BR/>" . $flightData['gate'] . "</td>";
            }
            elseif(isset($flightData['terminal']))
            {
                echo "<td>T-" . $flightData['terminal'] . "<BR/>-</td>";
            }
            else
            {
                echo "<td>N/A</td>";
            }
            echo "<td>" . $flightData['currentTime'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    echo "</body></html>"
?>