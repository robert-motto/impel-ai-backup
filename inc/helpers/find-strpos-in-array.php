<?php
    function find_strpos_in_array($array, $searchString){
        return array_filter($array, function($array) use ($searchString) {
            return strpos($array, $searchString) !== false;
        });
    }
