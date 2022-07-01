<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use PostgisTrait;
    use HasFactory;
    protected $guarded = [];
    protected $postgisFields = [
        'position',
    ];
    protected $postgisTypes = [
        'position' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ],
    ];
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function busschool()
    {
        return $this->hasMany(BusSchool::class);
    }
    public function student()
    {
        return $this->hasMany(Student::class);
    }
    public function driver()
    {
        return $this->hasMany(Driver::class);
    }
    public function zone()
    {
        return $this->hasMany(Zone::class);
    }
    public function traject()
    {
        return $this->hasMany(Traject::class);
    }
}
