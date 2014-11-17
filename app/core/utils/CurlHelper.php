<?php
namespace app\core\utils;

    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class CurlHelper
    {
        public static function execute($url)
        {
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($handle, CURLOPT_URL, $url);
            $response     = curl_exec($handle);
            $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            //todo: better error handling of response code needed.
            //todo: split out decode into separate method probably once we get error handling figured out
            return json_decode($response, true);
        }
    }
?>