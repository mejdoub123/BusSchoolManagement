<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrajectResource;
use App\Models\Traject;
use Illuminate\Http\Request;
use MStaack\LaravelPostgis\Geometries\LineString;

class TrajectsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|integer',
            'bus_school_id' => 'required|integer',
            'geometry' => 'required|array',
            'type' => 'required|string',
            'stops' => 'nullable|array',
        ]);
        $geometry = \App\Utils\GeometryConverter::convertArrayLatLngToPoints($request->input('geometry'));
        if (!$request->input('stops')) {
            $traject = Traject::create([
                'school_id' => $request->input('school_id'),
                'bus_school_id' => $request->input('bus_school_id'),
                'geometry' => new LineString($geometry),
                'type' => $request->input('type'),
                'stops' => $request->input('stops'),
            ]);
        } else {
            $stops = \App\Utils\GeometryConverter::convertArrayLatLngToPoints($request->input('stops'));
            $traject = Traject::create([
                'school_id' => $request->input('school_id'),
                'bus_school_id' => $request->input('bus_school_id'),
                'geometry' => new LineString($geometry),
                'type' => $request->input('type'),
                'stops' => new LineString($stops),
            ]);
        }
        return response()->json([
            'traject' => $traject,
        ], 201);
    }
    //Fetch the traject for specific bus school
    public function showBusSchoolTrajects($bus_school_id)
    {
        $trajects = Traject::where('bus_school_id', $bus_school_id)->get();

        if ($trajects) {
            return response()->json([
                'trajects' => TrajectResource::collection($trajects),
            ], 200);
        } else {
            return response()->json([
                'message' => 'This bus school doesn\'t have any traject yet!',
            ], 404);
        }
    }

    public function showSchoolTrajects($school_id)
    {
        $trajects = Traject::where('school_id', $school_id)->get();

        if ($trajects) {
            return response()->json([
                'trajects' => TrajectResource::collection($trajects),
            ], 200);
        } else {
            return response()->json([
                'message' => 'This bus school doesn\'t have any traject yet!',
            ], 404);
        }
    }
    public function updateTraject(Request $request, $traject_id)
    {
        $request->validate([
            'geometry' => 'required|array',
            'stops' => 'nullable|array',
        ]);
        if (!$request->stops) {
            $geometry = \App\Utils\GeometryConverter::convertArrayLatLngToPoints($request->input('geometry'));
            Traject::where('id', $traject_id)->update([
                'geometry' => new LineString($geometry),
            ]);
        } else {
            $geometry = \App\Utils\GeometryConverter::convertArrayLatLngToPoints($request->input('geometry'));
            $stops = \App\Utils\GeometryConverter::convertArrayLatLngToPoints($request->input('stops'));
            Traject::where('id', $traject_id)->update([
                'geometry' => new LineString($geometry),
                'stops' => new LineString($stops)
            ]);
        }

        $traject = Traject::where('id', $traject_id)->first();
        return response()->json([
            'traject' => new TrajectResource($traject),
        ], 201);
    }
}
