<?php
namespace app\core\utils;

    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class ViewUtil
    {
        public static function renderFidsView($currentAirportData, $localTimeStamp, $airportFidsData)
        {
            //todo: still show something even if no data.
            if(isset($airportFidsData['fidsData']))
            {

                $fidsToFlightDataAdapter = new FidsToFlightDataAdapter($airportFidsData['fidsData']);
                static::renderGridView($currentAirportData, $localTimeStamp, $fidsToFlightDataAdapter);
            }
        }

        public static function renderScheduledView($currentAirportData, $localTimeStamp, $airportScheduledData)
        {
            //todo: still show something even if no data.
            if(isset($airportScheduledData['scheduledFlights']))
            {
                $scheduledToFlightDataAdapter = new ScheduledToFlightDataAdapter($airportScheduledData['scheduledFlights'],
                                                $airportScheduledData['appendix']);
                static::renderGridView($currentAirportData, $localTimeStamp, $scheduledToFlightDataAdapter);
            }
        }

        protected static function renderGridView($currentAirportData, $localTimeStamp, FlightDataAdapter $flightDataAdapter)
        {
            //todo: figure out how to get this effectively ---
            //todo: ---technically we could pass flightID instead of this stamp. then get local on delivery on reup on index.php
            $localArrivalTimeStamp = time();
            echo "<BR>[<a href='?currentAirportCode=ORD&jump=1'>go home</a>]"; //todo: should get code from static var or something since it could be differnet for other users
            echo "<h1>" . $currentAirportData['city'] . ' - ' . $currentAirportData['countryName'] . " - " .
                $currentAirportData['fs'] . ' - ' .
                date("F j, Y, g:i a", $localTimeStamp) . "</h1>";
            echo "[<a href='?currentAirportCode=" . $currentAirportData['fs'] .
                 "&jump=0&localArrivalTimeStamp=" . ($localTimeStamp - 3600) . "'>prev hour</a>]";
            echo " [<a href='?currentAirportCode=" . $currentAirportData['fs'] .
                 "&jump=0&localArrivalTimeStamp=" . ($localTimeStamp + 3600) . "'>next hour</a>]";
            echo "<table border=1>";
            echo "<tr>";
            echo "<td></td>";
           // echo "<td>Airline Code</td>";
            echo "<td>Flight</td>";
            echo "<td>City/Airport</td>";
            echo "<td>Country Code</td>";
            echo "<td>Departure Time</td>";
            echo "</tr>";
            foreach ($flightDataAdapter->getCollection() as $flightData)
            {
                if($flightData['destinationCountryCode'] == 'US' && $flightData['originCountryCode'] == 'US')
                {
                    continue;
                }
                if($flightData['isCodeShare'])
                {
                    continue;
                }
                $flagImageUrl = GeoNamesHelper::getFlagImageUrlByCountryCode($flightData['destinationCountryCode']);
                echo "<tr>";
                echo "<td><img src='" . $flightData['airlineLogoUrlPng'] . "' height=50 width=150></td>";
              //  echo "<td>" . $flightData['airlineName'] . "</td>";
               // echo "<td>" . $flightData['airlineCode'] . "</td>";
                echo "<td>" . $flightData['airlineCode'] . '-' . $flightData['flightNumber'] . "</td>";
                echo "<td>" . $flightData['city'] . ' - ' . $flightData['destinationAirportCode'] . "<br/>" .
                    "[<a href='?currentAirportCode=" . $flightData['destinationAirportCode'] . "&jump=1'>jump</a>] [" .
                    "<a href='?currentAirportCode=" . $flightData['destinationAirportCode'] .
                    "&jump=0&localArrivalTimeStamp=" . strtotime($flightData['arrivalTime']) . "'>fly</a>]" .
                    "</td>";
                echo "<td>" . $flightData['destinationCountryCode'] .
                    " <img src='" . $flagImageUrl.  "'/></td>";
                /**
                if(!empty($flightData['terminal']) && !empty($flightData['gate']))
                {
                    echo "<td>T-" . $flightData['terminal'] . "<BR/>" . $flightData['gate'] . "</td>";
                }
                elseif(!empty($flightData['terminal']))
                {
                    echo "<td>T-" . $flightData['terminal'] . "<BR/>-</td>";
                }
                else
                {
                    echo "<td>N/A</td>";
                }
                **/
                echo "<td>" . date("g:i a", $flightData['departureTimeStamp']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
?>