<?php
    require_once('library/FlightDataAdapter.php');
    class ScheduledToFlightDataAdapter extends FlightDataAdapter
    {
        protected $appendixData = array();

        public function __construct(array $schedulesData, $appendixData)
        {
            $this->appendixData = $appendixData;
            foreach($schedulesData as $flightData)
            {
                $airportData = $this->resolveAirportDataByCode($flightData['arrivalAirportFsCode']);
                $data = array(
                    'destinationCountryCode'    => $airportData['countryCode'],
                    'originCountryCode'         => null,//$flightData['originCountryCode'], //todo: pass origin airport code and call again to get airport
                    'airlineLogoUrlPng'         => 'http://d3o54sf0907rz4.cloudfront.net/airline-logos/v2/centered/logos/png/300x100/' .
                                                   strtolower($flightData['carrierFsCode']) . '-logo.png',
                    'airlineName'               => $this->resolveAirlineNameByCode($flightData['carrierFsCode']),
                    'airlineCode'               => $flightData['carrierFsCode'],
                    'flightNumber'              => $flightData['flightNumber'],
                    'remarks'                   => null,//$flightData['remarks'],
                    'city'                      => $airportData['city'],
                    'destinationAirportCode'    => $flightData['arrivalAirportFsCode'],
                    'terminal'                  => null,//$flightData['terminal'],
                    'gate'                      => null,//$flightData['gate'],
                    'departureTime'             => $flightData['departureTime'],
                    'departureTimeStamp'        => strtotime($flightData['departureTime']),
                    'arrivalTime'               => $flightData['arrivalTime'],
                    'isCodeShare'               => $flightData['isCodeshare'],
                );

                $this->collection[] = $data;
            }
            usort($this->collection, "static::sortByDepartureTime");
        }

        public static function sortByDepartureTime($a, $b)
        {
            return $a['departureTimeStamp'] - $b['departureTimeStamp'];
        }



        protected function resolveAirlineNameByCode($fsCode)
        {
            //todo: not efficient should have local data for airlines/airports...
            foreach($this->appendixData['airlines'] as $airlineData)
            {
                if($airlineData['fs'] === $fsCode)
                {
                    return $airlineData['name'];
                }
            }

        }

        protected function resolveAirportDataByCode($fsCode)
        {
            //todo: not efficient should have local data for airlines/airports...
            foreach($this->appendixData['airports'] as $airportData)
            {
                if($airportData['fs'] === $fsCode)
                {
                    return $airportData;
                }
            }

        }
    }
?>