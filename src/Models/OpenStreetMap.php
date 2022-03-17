<?php


namespace App\Models;


use App\Services\GeolocationServiceInterFace;

class OpenStreetMap implements GeolocationServiceInterFace
{
    public function getCoordinatesFromAddress($address): string
    {
        return "{$address} from OpenStreetMap.";
    }
}