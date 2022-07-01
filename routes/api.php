<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusSchoolsController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrajectsController;
use App\Http\Controllers\ZonesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'update_password']);
    Route::post('school', [SchoolController::class, 'store']);
    Route::get('school/{admin_id}', [SchoolController::class, 'show']);
    Route::post('busschool', [BusSchoolsController::class, 'store']);
    Route::get('busschool/{school_id}', [BusSchoolsController::class, 'show']);
    Route::put('busschool/{busschool_id}', [BusSchoolsController::class, 'update']);
    Route::delete('user/{user}', [AuthController::class, 'destroy']);
    Route::get('students', [StudentController::class, 'index']);
    Route::post('students', [StudentController::class, 'store']);
    Route::put('students/busschool/add', [StudentController::class, 'addStudentsToBusSchool']);
    Route::put('students/busschool/delete', [StudentController::class, 'deleteStudentsFormBusSchool']);
    Route::get('students/zone/{zone}', [StudentController::class, 'findStudentsByZone']);
    Route::get('students/school/{school_id}', [StudentController::class, 'showSchoolStudents']);
    Route::get('students/busschool/{bus_school_id}', [StudentController::class, 'showBusSchoolStudents']);
    Route::post('zones', [ZonesController::class, 'store']);
    Route::put('zones/{zone_id}', [ZonesController::class, 'updateZone']);
    Route::get('zones/busschool/{bus_school_id}', [ZonesController::class, 'showBusSchoolZone']);
    Route::get('zones/school/{school_id}', [ZonesController::class, 'showSchoolZones']);
    Route::post('trajects', [TrajectsController::class, 'store']);
    Route::put('trajects/{traject_id}', [TrajectsController::class, 'updateTraject']);
    Route::get('trajects/busschool/{bus_school_id}', [TrajectsController::class, 'showBusSchoolTrajects']);
    Route::get('trajects/school/{school_id}', [TrajectsController::class, 'showSchoolTrajects']);
    Route::post('drivers', [DriverController::class, 'store']);
    Route::get('drivers/busschool/{bus_school_id}', [DriverController::class, 'showBusSchoolDriver']);
    Route::get('drivers/school/{school_id}', [DriverController::class, 'showSchoolDrivers']);
    Route::put('drivers/{driver_id}', [DriverController::class, 'updateDriver']);
    Route::post('planning', [PlanningController::class, 'store']);
    Route::put('planning/{planning_id}', [PlanningController::class, 'update']);
    Route::get('planning/{bus_school_id}', [PlanningController::class, 'show']);
});
