<?php
    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class PixabayHelper
    {
        //$searchTerm =  urlencode($currentAirportData['city'] . ' ' .  $currentAirportData['countryName']);
        /**
        //todo: move this
        //we can actually move around and only use the best images if we had a db and storage for this... adds complexity...
        $url = "http://pixabay.com/api/?username=&key=&search_term=" . $searchTerm . "&image_type=photo&min_width=1000&safesearch=true&per_page=5";
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($handle, CURLOPT_USERAGENT, $userAgentType);
        curl_setopt($handle, CURLOPT_URL, $url);
        $response     = curl_exec($handle);
        $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $decodedResponse = json_decode($response, TRUE);
        $decodedResponse4 = $decodedResponse;
        echo $responseCode;

        echo "<pre>";
        print_r($decodedResponse4);     ///need to get high-res approval!
        echo "</pre>";

        if(!empty($decodedResponse4['hits']))
        {
        $imageToUse = array_rand($decodedResponse4['hits']);
        echo "<img src='" . $decodedResponse4['hits'][$imageToUse]['webformatURL'] . "'>";
        }
         **/
    }