<?php
    require_once('library/FlightDataAdapter.php');
    class FidsToFlightDataAdapter extends FlightDataAdapter
    {
        public function __construct(array $fidsData)
        {
            foreach($fidsData as $flightData)
            {
                $data = array(
                    'destinationCountryCode'    => $flightData['destinationCountryCode'],
                    'originCountryCode'         => $flightData['originCountryCode'],
                    'airlineLogoUrlPng'         => $flightData['airlineLogoUrlPng'],
                    'airlineName'               => $flightData['airlineName'],
                    'airlineCode'               => $flightData['airlineCode'],
                    'flightNumber'              => $flightData['flightNumber'],
                    'remarks'                   => $flightData['remarks'],
                    'city'                      => $flightData['city'],
                    'destinationAirportCode'    => $flightData['destinationAirportCode'],
                    'terminal'                  => empty($flightData['terminal']) ? null : $flightData['terminal'],
                    'gate'                      => empty($flightData['gate']) ? null : $flightData['gate'],
                    'departureTime'             => $flightData['currentTime'],
                    'arrivalTime'               => null,
                );
                $this->collection[] = $data;
            }
        }
    }