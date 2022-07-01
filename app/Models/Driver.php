<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    use HasUser;
    protected $guarded = [];
    public function busschool()
    {
        return $this->belongsTo(BusSchool::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
