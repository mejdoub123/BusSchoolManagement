<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class BusSchool extends Model
{
    use HasFactory;
    use PostgisTrait;

    protected $guarded = [];
    protected $postgisFields = [
        'current_position',
    ];
    protected $postgisTypes = [
        'current_position' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ],
    ];
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function driver()
    {
        return $this->hasOne(Driver::class);
    }
    public function zone()
    {
        return $this->hasOne(Zone::class);
    }
    public function planning()
    {
        return $this->hasOne(Planning::class);
    }
    public function student()
    {
        return $this->hasMany(Student::class);
    }
    public function traject()
    {
        return $this->hasMany(Traject::class);
    }
}
