<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSchoolRequest;
use App\Models\Admin;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MStaack\LaravelPostgis\Geometries\Point;

class SchoolController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|integer|unique:schools',
            'name' => 'required|string|unique:schools',
            'address' => 'required|string',
            'address_lat' => 'required|string',
            'address_lng' => 'required|string'
        ]);
        //Create new school 
        $school = School::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'position' => new Point($request->input('address_lat'), $request->input('address_lng')),
            'admin_id' => $request->input('admin_id')
        ]);

        return response()->json([
            'school' => $school,
        ], 201);
    }
    //Fetch school for specific admin
    public function show($admin_id)
    {
        $school = School::where('admin_id', $admin_id)->first();

        if ($school) {
            return response()->json([
                'school' => $school,
            ], 200);
        } else {
            return response()->json([
                'message' => 'This admin doesn\'t add a school yet!',
            ], 404);
        }
    }
}
