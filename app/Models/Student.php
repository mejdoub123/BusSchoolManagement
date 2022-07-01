<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Student extends Model
{
    use HasFactory;
    use HasUser;
    use PostgisTrait;
    protected $guarded = [];
    protected $postgisFields = [
        'address_position',
    ];
    protected $postgisTypes = [
        'address_position' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ],
    ];
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function busschool()
    {
        return $this->belongsTo(BusSchool::class);
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
