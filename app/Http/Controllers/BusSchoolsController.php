<?php

namespace App\Http\Controllers;

use App\Models\BusSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusSchoolsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|integer',
            'capacity' => 'required|integer',
            'matricule' => 'required|string|unique:bus_schools'
        ]);
        //Create new busschool 
        $busschool = BusSchool::create([
            'capacity' => $request->input('capacity'),
            'matricule' => $request->input('matricule'),
            'school_id' => $request->input('school_id')
        ]);

        return response()->json([
            'busschool' => [
                'id' => $busschool->id,
                'school_id' => $busschool->school_id,
                'matricule' => $busschool->matricule,
                'capacity' => $busschool->capacity
            ],
        ], 201);
    }
    //Fetch all BusSchools for a specific School
    public function show($school_id)
    {
        $busschools = BusSchool::select('id', 'school_id', 'capacity', 'matricule')->where('school_id', $school_id)->get();
        if (!$busschools) {
            return response()->json([
                'message' => 'This school doesn\'t have any bus schools yet!',
            ], 404);
        } else {
            return response()->json([
                'busschools' => $busschools,
            ], 200);
        }
    }
    public function update(Request $request, $busschool_id)
    {
        $request->validate([
            'matricule' => 'nullable|unique:bus_schools|string',
            'capacity' => 'nullable|integer'
        ]);
        $busschool = BusSchool::where('id', DB::raw($busschool_id))->first();
        if ($request->matricule || $request->capacity) {
            if ($request->matricule) {
                $busschool->matricule = $request->matricule;
            }
            if ($request->capacity) {

                $busschool->capacity = $request->capacity;
            }
            $busschool->save();
        }
        return response()->json([
            'busschool' => $busschool,
        ], 200);
    }
}
