<?php

namespace App\Utils;

use MStaack\LaravelPostgis\Geometries\Point;

class GeometryConverter
{

    public static function convertArrayToPoints($arr)
    {

        $points = [];
        foreach ($arr as $item) {
            $points[] = new Point($item[1], $item[0]);
        }

        return $points;
    }
    public static function convertArrayLatLngToPoints($arr)
    {
        $points = [];
        foreach ($arr as $item) {
            // dd($item);
            $points[] = new Point($item["lat"], $item["lng"]);
        }
        return $points;
    }
}
