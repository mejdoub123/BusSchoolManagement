<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Zone extends Model
{
    use PostgisTrait;
    use HasFactory;
    protected $guarded = [];
    protected $postgisFields = [
        'geom',
    ];
    protected $postgisTypes = [
        'geom' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ],
    ];
    public function busschool()
    {
        return $this->belongsTo(BusSchool::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
