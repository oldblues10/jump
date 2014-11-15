<?php
    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class FlightStatsHelper
    {
        const FLEX_API_BASE_URL = 'https://api.flightstats.com/flex/';

        protected $appId;

        protected $appKey;

        public function __construct($appId, $appKey)
        {
            $this->appId  = $appId;
            $this->appKey = $appKey;
        }

        public function getAirportDataByCode($code)
        {
            $url = static::FLEX_API_BASE_URL . "airports/rest/v1/json/iata/" .
                   $code . "?appId=" . $this->appId . "&appKey=" . $this->appKey;
            $currentAirportData = CurlHelper::execute($url);
            return $currentAirportData['airports'][0];
        }

        public function getFidsByAirportCode($code)
        {
            $url =  static::FLEX_API_BASE_URL . "fids/rest/v1/json/" .
                    $code .  "/departures?appId=" . $this->appId . "&appKey=" . $this->appKey . "&includeCodeshares=false&" .
                    "timeWindowBegin=0&timeWindowEnd=500&" .
                    "requestedFields=airlineLogoUrlPng%2CdestinationAirportCode%2CoriginCountryCode%2C" .
                    "destinationCountryCode%2CairlineName%2CairlineCode%2Cterminal%2CflightNumber%2Ccity%2CcurrentTime%2Cgate%2Cremarks&" .
                    "lateMinutes=15&useRunwayTimes=false&excludeCargoOnlyFlights=true&sortFields=currentTime";
            return CurlHelper::execute($url);
        }


        public function getScheduledFlightsByAirportCodeAndDateAndTime($code, $year, $month, $day, $hour)
        {
            $dateTimeString = $year . '/' . $month . '/' . $day . '/' . $hour;
            $url  = static::FLEX_API_BASE_URL . "schedules/rest/v1/json/from/" . $code .
                    "/departing/" . $dateTimeString . "?appId=" . $this->appId . "&appKey=" . $this->appKey;
            return CurlHelper::execute($url);
        }
    }
?>