<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;


class Traject extends Model
{
    use HasFactory;
    use PostgisTrait;
    protected $guarded = [];
    protected $postgisFields = [
        'geometry', 'stops'
    ];
    protected $postgisTypes = [
        'geometry' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ], 
        'stops' => [
            'geomtype' => 'geometry',
            'srid' => 4326
        ]
    ];

    public function busschool()
    {
        return $this->belongsTo(BusSchool::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
