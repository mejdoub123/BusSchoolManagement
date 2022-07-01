<?php

namespace App\Http\Controllers;

use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MStaack\LaravelPostgis\Geometries\Polygon;
use MStaack\LaravelPostgis\Geometries\LineString;

class ZonesController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'school_id' => 'required|integer',
            'bus_school_id' => 'required|integer',
            'geom' => 'required|array',
        ]);

        $geometry = \App\Utils\GeometryConverter::convertArrayToPoints($request->input('geom'));

        $linestring = new LineString($geometry);
        $zone = Zone::create([
            'school_id' => $request->input('school_id'),
            'bus_school_id' => $request->input('bus_school_id'),
            'geom' => new Polygon([$linestring]),
        ]);

        return response()->json([
            'zone' => new ZoneResource($zone),
        ], 201);
    }
    //Fetch the zone for specific bus school
    public function showBusSchoolZone($bus_school_id)
    {
        $zone = Zone::where('bus_school_id', $bus_school_id)->first();

        if ($zone) {
            return response()->json([
                'zone' => new ZoneResource($zone),
            ], 200);
        } else {
            return response()->json([
                'message' => 'This bus school doesn\'t have any zone yet!',
            ], 404);
        }
    }
    //Fetch the zones for specific school
    public function showSchoolZones($school_id)
    {
        $zones = Zone::where('school_id', $school_id)->get();

        if ($zones) {
            return response()->json([
                'zones' => ZoneResource::collection($zones),
            ], 200);
        } else {
            return response()->json([
                'message' => 'This school doesn\'t have any zone yet!',
            ], 404);
        }
    }
    public function updateZone(Request $request, $zone_id)
    {
        $request->validate([
            'geom' => 'required|array',
        ]);
        $geometry = \App\Utils\GeometryConverter::convertArrayToPoints($request->input('geom'));

        $linestring = new LineString($geometry);
        Zone::where('id', $zone_id)->update([
            'geom' => new Polygon([$linestring]),
        ]);
        $zone = Zone::where('id', $zone_id)->first();
        return response()->json([
            'zone' =>  new ZoneResource($zone),
        ], 200);
    }
}
