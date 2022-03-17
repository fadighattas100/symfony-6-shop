<?php


namespace App\Services;


class StoreService
{
    private GeolocationServiceInterFace $geolocationServiceInterFace;

    public function __construct(GeolocationServiceInterFace $geolocationServiceInterFace) {
        $this->geolocationServiceInterFace = $geolocationServiceInterFace;
    }

    public function getStoreCoordinates($store) {
        return $this->geolocationServiceInterFace->getCoordinatesFromAddress($store->getAddress());
    }
}