<?php
    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class PixabayHelper
    {
        const API_BASE_URL = 'http://pixabay.com/api/';

        protected $username;

        protected $key;

        public function __construct($username, $key)
        {
            $this->username  = $username;
            $this->key = $key;
        }

        public function getImageUrl($searchTerm)
        {
            $url = static::API_BASE_URL . "?username=" . $this->username . "&key=" . $this->key . "&search_term=" . $searchTerm .
                   "&image_type=photo&min_width=1000&safesearch=true&per_page=5";
            $decodedResponse = CurlHelper::execute($url);
            if(!empty($decodedResponse['hits']))
            {
                $imageToUse = array_rand($decodedResponse['hits']);
                return $decodedResponse['hits'][$imageToUse]['webformatURL'];
            }
        }
    }