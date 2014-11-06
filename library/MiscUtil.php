<?php
    /**
     * Jump! Explore your world
     * Copyright (c) 2014 Jason Green http://zurmo.com
     * Licensed under the MIT license
     */
    class MiscUtil
    {
        public static function convertKelvinToFarenheit($kelvin)
        {
            return ($kelvin * 9/5) - 459.67;
        }
    }
?>