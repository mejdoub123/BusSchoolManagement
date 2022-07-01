<?php

namespace Database\Seeders;

use App\Models\BusSchool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $busschool = new BusSchool([
            'school_id' => 1,
            'matricule' => '489354|A|44',
            'capacity' => 27,
        ]);
        $busschool->save();
    }
}
