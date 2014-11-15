<?php
    abstract class FlightDataAdapter
    {
        protected $collection = array();

        public function getCollection()
        {
            return $this->collection;
        }
    }
?>