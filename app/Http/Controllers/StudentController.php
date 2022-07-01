<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MStaack\LaravelPostgis\Geometries\Point;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Student::query()->with('user');
        $allRecords = $request->boolean('all');

        if ($allRecords) {
            $students = $query->get();
        } else {
            $students = $query->paginate(1);
        }

        return StudentResource::collection($students);
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'address' => 'required|string|unique:students',
            'address_lat' => 'required|string',
            'address_lng' => 'required|string',
            'phone_number' => 'required|string|unique:students',
            'password' => 'required|string',
            'cne' => 'required|string|unique:students',
        ]);
        $student = new Student([
            'school_id' => $request->input('school_id'),
            'address' => $request->input('address'),
            'address_position' => new Point($request->input('address_lng'), $request->input('address_lat')),
            'phone_number' => $request->input('phone_number'),
            'cne' => $request->input('cne')
        ]);
        $student->save();
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
        $student->user()->save($user);
        return response()->json([
            'student' => [
                'id' => $user->id,
                'school_id' => $student->school_id,
                'bus_school_id' => $student->bus_school_id,
                'zone_id' => $student->zone_id,
                'name' => $user->name,
                'email' => $user->email,
                'cne' => $student->cne,
                'address' => $student->address,
                'address_position' => $student->address_position,
                'phone_number' => $student->phone_number,
                'profile_id' => $user->profile_id,
                'user_type' => $user->user_type
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function showSchoolStudents($school_id)
    {
        $students = Student::with('user:id,name,email,profile_id,profile_type')->where('school_id', $school_id)->get();

        // User::query()->raw
        if (!$students) {
            return response()->json([
                'message' => 'This school doesn\'t have any students yet!',
            ], 404);
        } else {
            return response()->json([
                'students' => StudentResource::collection($students),
            ], 200);
        }
    }

    public function showBusSchoolStudents($bus_school_id)
    {
        $students = Student::with('user:id,name,email,profile_id,profile_type')->where('bus_school_id', $bus_school_id)->get('id', 'school_id', 'cne', 'address', 'address_position', 'phone_number');

        // User::query()->raw
        if (!$students) {
            return response()->json([
                'message' => 'This school doesn\'t have any students yet!',
            ], 404);
        } else {
            //return StudentResource::collection($students);
            return response()->json([
                'students' => $students,
            ], 200);
        }
    }

    public function findStudentsByZone(Zone $zone)
    {
        $students = Student::select('students.id','students.school_id', 'students.zone_id', 'students.bus_school_id', 'students.cne', 'students.address_position', 'students.address', 'students.phone_number')
            ->with('user:id,name,email,profile_id,profile_type')
            ->where(DB::raw('ST_Intersects(students.address_position,zones.geom)'), DB::raw('true'))
            ->where('students.bus_school_id', NULL)
            ->join('zones', 'zones.id', DB::raw($zone->id))
            ->get();

        return response()->json([
            'students' => StudentResource::collection($students),
        ], 200);
    }


    public function addStudentsToBusSchool(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
            'zone_id' => 'required|integer',
            'bus_school_id' => 'required|integer'
        ]);
        Student::whereIn('id', $request->input('students'))->update([
            "zone_id" => $request->input('zone_id'),
            "bus_school_id" => $request->input('bus_school_id'),
        ]);
        return response()->json([
            'message' => 'Students added successfuly!',
        ], 204);
    }
    public function deleteStudentsFormBusSchool(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
        ]);
        Student::whereIn('id', $request->input('students'))->update([
            "zone_id" => null,
            "bus_school_id" => null
        ]);
        return response()->json([
            'message' => 'Students deleted successfuly!',
        ], 204);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
