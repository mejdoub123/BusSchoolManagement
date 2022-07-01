<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = new Student([
            'school_id' => 1,
            'bus_school_id' => 1,
            'zone_id' => 1,
            'address' => 'FFFFFFF',
            'phone_number' => 065555555,
            'cne' => 'gfhghg'
        ]);

        $student->save();

        $user = new User([
            'name' => 'student',
            'email' => 'student@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $student->user()->save($user);

        $user->assignRole('student');
    }
}
