<?php


namespace App\Services;


interface GeolocationServiceInterFace
{
    public function getCoordinatesFromAddress($address);
}