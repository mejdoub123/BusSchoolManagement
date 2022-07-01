<?php

namespace App\Http\Controllers;

use App\Http\Resources\DriverResource;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|integer',
            'bus_school_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'cin' => 'required|string|unique:admins',
        ]);
        $driver = new Driver([
            'school_id' => $request->input('school_id'),
            'bus_school_id' => $request->input('bus_school_id'),
            'cin' => $request->input('cin')
        ]);
        $driver->save();
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
        $driver->user()->save($user);
        return response()->json([
            'driver' => [
                'id' => $user->id,
                'school_id' => $driver->school_id,
                'bus_school_id' => $driver->bus_school_id,
                'name' => $user->name,
                'email' => $user->email,
                'cin' => $driver->cin,
                'profile_id' => $user->profile_id,
                'user_type' => $user->user_type
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function showBusSchoolDriver($bus_school_id)
    {
        $driver = Driver::with('user:id,name,email,profile_id,profile_type')->where('bus_school_id', $bus_school_id)->first();

        if ($driver) {
            return response()->json([
                'driver' => new DriverResource($driver),
            ], 200);
        } else {
            return response()->json([
                'message' => 'This bus school doesn\'t have any driver yet!',
            ], 404);
        }
    }

    public function showSchoolDrivers($school_id)
    {
        $drivers = Driver::with('user:id,name,email,profile_id,profile_type')->where('school_id', $school_id)->get();

        if ($drivers) {
            return response()->json([
                'drivers' => DriverResource::collection($drivers),
            ], 200);
        } else {
            return response()->json([
                'message' => 'This school doesn\'t have any driver yet!',
            ], 404);
        }
    }
    public function updateDriver(Request $request, $driver_id)
    {

        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|unique:users,email|string',
            'cin' => 'nullable|unique:drivers|string'
        ]);

        if ($request->cin) {

            $driver = Driver::find($driver_id);
            $driver->cin = $request->cin;
            $driver->save();

            if ($request->email || $request->name) {
                $user = User::where('profile_id', $driver_id)->where('profile_type', '=', 'App\\Models\\Driver')->first();
                if ($request->email) {
                    $user->email = $request->email;
                }
                if ($request->name) {
                    $user->name = $request->name;
                }
                $user->save();
            } else {
                $user = User::where('profile_id', $driver_id)->where('profile_type', '=', 'App\\Models\\Driver')->first();
            }
            return response()->json([
                'driver' => [
                    'id' => $user->id,
                    'school_id' => $driver->school_id,
                    'bus_school_id' => $driver->bus_school_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'cin' => $driver->cin,
                    'profile_id' => $user->profile_id,
                    'user_type' => $user->user_type
                ]
            ], 200);
        } else if ($request->email || $request->name) {
            $driver = Driver::find($driver_id);
            $user = User::where('profile_id', $driver_id)->where('profile_type', '=', 'App\\Models\\Driver')->first();
            if ($request->email) {
                $user->email = $request->email;
            }
            if ($request->name) {
                $user->name = $request->name;
            }
            $user->save();
            return response()->json([
                'driver' => [
                    'id' => $user->id,
                    'school_id' => $driver->school_id,
                    'bus_school_id' => $driver->bus_school_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'cin' => $driver->cin,
                    'profile_id' => $user->profile_id,
                    'user_type' => $user->user_type
                ]
            ], 200);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        //
    }
}
