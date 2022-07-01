<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanningResource;
use App\Models\Planning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanningController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'bus_school_id' => 'required|int',
            'monday_go_at' => 'required|string',
            'monday_comeback_at' => 'required|string',
            'tuesday_go_at' => 'required|string',
            'tuesday_comeback_at' => 'required|string',
            'wednesday_go_at' => 'required|string',
            'wednesday_comeback_at' => 'required|string',
            'thursday_go_at' => 'required|string',
            'thursday_comeback_at' => 'required|string',
            'friday_go_at' => 'required|string',
            'friday_comeback_at' => 'required|string',
        ]);
        $planning = Planning::create([
            'bus_school_id' => $request->input('bus_school_id'),
            'monday_go_at' => $request->input('monday_go_at'),
            'monday_comeback_at' => $request->input('monday_comeback_at'),
            'tuesday_go_at' => $request->input('tuesday_go_at'),
            'tuesday_comeback_at' => $request->input('tuesday_comeback_at'),
            'wednesday_go_at' => $request->input('wednesday_go_at'),
            'wednesday_comeback_at' => $request->input('wednesday_comeback_at'),
            'thursday_go_at' => $request->input('thursday_go_at'),
            'thursday_comeback_at' => $request->input('thursday_comeback_at'),
            'friday_go_at' => $request->input('friday_go_at'),
            'friday_comeback_at' => $request->input('friday_comeback_at'),
        ]);
        return response()->json([
            'planning' => new PlanningResource($planning)
        ], 201);
    }
    //Fetch the planning for specific bus school
    public function show($bus_school_id)
    {
        $planning = Planning::where('bus_school_id', $bus_school_id)->first();

        if ($planning) {
            return response()->json([
                'planning' => new PlanningResource($planning),
            ], 200);
        } else {
            return response()->json([
                'message' => 'This bus school doesn\'t have any planning yet!',
            ], 404);
        }
    }
    public function update(Request $request, $planning_id)
    {
        $request->validate([
            'monday_go_at' => 'nullable|string',
            'monday_comeback_at' => 'nullable|string',
            'tuesday_go_at' => 'nullable|string',
            'tuesday_comeback_at' => 'nullable|string',
            'wednesday_go_at' => 'nullable|string',
            'wednesday_comeback_at' => 'nullable|string',
            'thursday_go_at' => 'nullable|string',
            'thursday_comeback_at' => 'nullable|string',
            'friday_go_at' => 'nullable|string',
            'friday_comeback_at' => 'nullable|string',
        ]);
        $planning = Planning::where('id', DB::raw($planning_id))->first();
        if (
            !$request->monday_go_at ||
            !$request->monday_comeback_at ||
            !$request->tuesday_go_at ||
            !$request->tuesday_comeback_at ||
            !$request->wednesday_go_at ||
            !$request->wednesday_comeback_at ||
            !$request->thursday_go_at ||
            !$request->thursday_comeback_at ||
            !$request->friday_go_at ||
            !$request->friday_comeback_at
        ) {
            if ($request->monday_go_at) {
                $planning->monday_go_at = $request->monday_go_at;
            }
            if ($request->monday_comeback_at) {
                $planning->monday_comeback_at = $request->monday_comeback_at;
            }
            if ($request->tuesday_go_at) {
                $planning->tuesday_go_at = $request->tuesday_go_at;
            }
            if ($request->tuesday_comeback_at) {
                $planning->tuesday_comeback_at = $request->tuesday_comeback_at;
            }
            if ($request->wednesday_go_at) {
                $planning->wednesday_go_at = $request->wednesday_go_at;
            }
            if ($request->wednesday_comeback_at) {
                $planning->wednesday_comeback_at = $request->wednesday_comeback_at;
            }
            if ($request->thursday_go_at) {
                $planning->thursday_go_at = $request->thursday_go_at;
            }
            if ($request->thursday_comeback_at) {
                $planning->thursday_comeback_at = $request->thursday_comeback_at;
            }
            if ($request->friday_go_at) {
                $planning->friday_go_at = $request->friday_go_at;
            }
            if ($request->friday_comeback_at) {
                $planning->friday_comeback_at = $request->friday_comeback_at;
            }
        }
        $planning->save();
        return response()->json([
            'planning' => new PlanningResource($planning),
        ], 200);
    }
}
