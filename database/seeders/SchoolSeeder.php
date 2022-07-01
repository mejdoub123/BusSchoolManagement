<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $school = new School([
            'admin_id'=>1,
            'name' =>'FSTETOUAN',
            'address'=>'Tetouan',
            'position'=>'POINT(-5.375829215347715 35.56914278320627)'
        ]);
        $school->save();
    }
}
