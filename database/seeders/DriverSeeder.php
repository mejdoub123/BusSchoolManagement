<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $driver = new Driver([
            'bus_school_id' => 1,
            'cin' => 'gfhghg',
        ]);

        $driver->save();
        $user =  User::create([
            'name' => 'driver',
            'email' => 'driver@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $driver->user()->save($user);
        $user->assignRole('driver');
    }
}
